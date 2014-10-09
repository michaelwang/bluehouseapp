//
//  PostDetailViewController.swift
//  post
//
//  Created by Derek Li on 14-10-8.
//  Copyright (c) 2014年 Derek Li. All rights reserved.
//

import Foundation
import UIKit

class PostDetailViewController:ViewController,UITableViewDelegate,UITableViewDataSource {
    var refreshControl = UIRefreshControl()
    var titleLabel:         UILabel!
    var titleInfoLabel:     UILabel!
    var contentLabel:       UILabel!
    var contentInfoLabel:   UILabel!
    var createdLabel:       UILabel!
    var createdInfoLabel:   UILabel!
    var modifiedLabel:      UILabel!
    var modifiedInfoLabel:  UILabel!
    var post:               Post!
    
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        self.navigationItem.title = "帖子详情"
        
        self.initViewStyle()
        
        self.view.addSubview(titleLabel)
        self.view.addSubview(contentLabel)
        self.view.addSubview(createdLabel)
        self.view.addSubview(modifiedLabel)
        
        self.view.addSubview(titleInfoLabel)
        self.view.addSubview(contentInfoLabel)
        self.view.addSubview(createdInfoLabel)
        self.view.addSubview(modifiedInfoLabel)
        
        self.view.addSubview(self.tableView!)
        
        
        
        self.getPostData()
        
    }
    
    func getPostData(){
        
        if post.id == 0 {
            return
        }
        var dl=HttpClient()
        //        var url = "http://192.168.1.102:8000/post/\(post.id)"
        var url = "\(Constant().URL_POST_DETAIL)\(post.id)"
        dl.downloadFromGetUrl(url, completionHandler: {(data: NSData?, error: NSError?) -> Void in
            if (error != nil){
                println("error=\(error!.localizedDescription)")
            }else{
                var dict=NSJSONSerialization.JSONObjectWithData(data!, options:.MutableContainers, error:nil) as? NSDictionary
                dict=NSJSONSerialization.JSONObjectWithData(data!, options:.MutableContainers, error:nil) as? NSDictionary
                println("\(dict)")
                var postData:NSDictionary = dict?.objectForKey("data") as NSDictionary
                var commentResult:NSDictionary = dict?.objectForKey("comments") as NSDictionary
                self.dataArray =  commentResult.objectForKey("items") as NSArray
                self.post = Post(dic: postData)
                
                self.refreshView()
                
            }
        })
    }
    
    func refreshView(){
        self.titleInfoLabel.text = self.post.title
        self.contentInfoLabel.text = self.post.content
        self.createdInfoLabel.text = self.post.created
        self.modifiedInfoLabel.text = self.post.modified
        self.tableView?.reloadData()
    }
    
    func initViewStyle(){
        
        var viewSize = self.view.frame.size
        var viewOrgin = self.view.frame.origin
        
        var labelWidth:CGFloat = 100.0
        var textFieldWidth:CGFloat = 250.0
        var btnWidth:CGFloat = 150.0
        
        var left:CGFloat = (viewSize.width)-btnWidth
        
        
        titleLabel = UILabel(frame:CGRect(origin: CGPointMake((viewSize.width - labelWidth - textFieldWidth)/2, 80.0), size: CGSizeMake(labelWidth,20)))
        titleLabel.text = "标题:"
        
        titleInfoLabel = UILabel(frame:CGRect(origin: CGPointMake((viewSize.width + labelWidth - textFieldWidth)/2, 80.0), size: CGSizeMake(textFieldWidth,20)))
        
        
        contentLabel = UILabel(frame:CGRect(origin: CGPointMake((viewSize.width - labelWidth - textFieldWidth)/2, 100.0), size: CGSizeMake(labelWidth,20)))
        contentLabel.text = "内容:"
        
        contentInfoLabel = UILabel(frame:CGRect(origin: CGPointMake((viewSize.width + labelWidth - textFieldWidth)/2, 100.0), size: CGSizeMake(textFieldWidth,20)))
        
        createdLabel = UILabel(frame:CGRect(origin: CGPointMake((viewSize.width - labelWidth - textFieldWidth)/2, 120.0), size: CGSizeMake(labelWidth,20)))
        createdLabel.text = "创建时间:"
        
        createdInfoLabel = UILabel(frame:CGRect(origin: CGPointMake((viewSize.width + labelWidth - textFieldWidth)/2, 120.0), size: CGSizeMake(textFieldWidth,20)))
        
        modifiedLabel = UILabel(frame:CGRect(origin: CGPointMake((viewSize.width - labelWidth - textFieldWidth)/2, 140.0), size: CGSizeMake(labelWidth,20)))
        modifiedLabel.text = "修改时间:"
        
        modifiedInfoLabel = UILabel(frame:CGRect(origin: CGPointMake((viewSize.width + labelWidth - textFieldWidth)/2, 140.0), size: CGSizeMake(textFieldWidth,20)))
        
        var frame = self.view.frame
        self.tableView = UITableView(frame: CGRect(origin: CGPointMake(0, 170.0), size: CGSizeMake(frame.size.width,frame.size.height-170)), style:UITableViewStyle.Plain)
        self.tableView!.delegate = self
        self.tableView!.dataSource = self
        self.tableView!.registerClass(UITableViewCell.self, forCellReuseIdentifier: "MyTestCell")
        
        
    }
    
    
    // MARK: - UITableViewDataSource
    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return dataArray.count;
    }
    
    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        
        let cell = UITableViewCell(style: UITableViewCellStyle.Subtitle, reuseIdentifier: "newsCell")
        
        //let obj: New = dataArray[indexPath.row] as New
        let obj:NSDictionary = dataArray[indexPath.row] as NSDictionary
        
        cell.textLabel?.text = obj.objectForKey("content") as? String
        
        
        //        let dateFormatter = NSDateFormatter()
        //        dateFormatter.dateFormat = "yyyy年 MM月 dd日"
        //
        //        let str = dateFormatter.stringFromDate(obj.title)
        cell.detailTextLabel?.text = obj.objectForKey("created") as? String
        return cell;
    }
    
    func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath){
        //        下面是取消点击后的选中
        //        tableView.deselectRowAtIndexPath(indexPath, animated: true)
        
        var commentDetailVC = CommentDetailViewController()
        commentDetailVC.comment = Comment(dic: self.dataArray[indexPath.row] as NSDictionary)
        self.navigationController?.pushViewController(commentDetailVC , animated: true)
    }
    
}