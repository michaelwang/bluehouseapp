//
//  Constant.swift
//  post
//
//  Created by Derek Li on 14-10-8.
//  Copyright (c) 2014年 Derek Li. All rights reserved.
//

import Foundation

//let HTTP_PATH:String = "http://192.168.1.101:8000/"
let HTTP_PATH:String = "http://127.0.0.1:8000/"

class Constant{
    let URL_POST_LIST:String = "\(HTTP_PATH)post/"
    let URL_POST_CREATE:String = "\(HTTP_PATH)post/"
    let URL_POST_DETAIL:String = "\(HTTP_PATH)post/"
    
    let URL_COMMENT_LIST:String = "\(HTTP_PATH)post/"
    let URL_COMMENT_ADD:String = "\(HTTP_PATH)post/"
    let URL_COMMENT_DETAIL:String = "\(HTTP_PATH)postcomment/"
    
    let URL_USER_LOGIN:String = "\(HTTP_PATH)login/"
    let URL_USER_REGIST:String = "\(HTTP_PATH)post/"
    
    init(){
    }
}