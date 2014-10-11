//
//  Comment.swift
//  post
//
//  Created by Derek Li on 14-10-8.
//  Copyright (c) 2014年 Derek Li. All rights reserved.
//

import Foundation

class Comment{
    var id:Int = 0
    var modified:String?
    var created:String?
    var content:String?
    init(){
        
    }
    init(dic:NSDictionary){
        self.id = dic.objectForKey("id") as Int
        self.modified = dic.objectForKey("modified") as? String
        self.content = dic.objectForKey("content") as? String
        self.created = dic.objectForKey("created") as? String
    }
    
}