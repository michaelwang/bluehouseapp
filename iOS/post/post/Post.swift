//
//  Post.swift
//  post
//
//  Created by Derek Li on 14-10-8.
//  Copyright (c) 2014年 Derek Li. All rights reserved.
//

import Foundation

class Post{
    var id:Int = 0
    var title:String?
    var content:String?
    var created:String?
    var enabled:Int?
    var status:Int?
    var modified:String?
    init(){
        
    }
    init(dic:NSDictionary){
        
        self.id = dic.objectForKey("id") as Int
        self.title = dic.objectForKey("title") as? String
        self.content = dic.objectForKey("content") as? String
        self.created = dic.objectForKey("created") as? String
        self.enabled = dic.objectForKey("enabled") as? Int
        self.status = dic.objectForKey("status") as? Int
        self.modified = dic.objectForKey("modified") as? String
        
        println("\(self.id)")
    }
    
}