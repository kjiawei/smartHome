//
//  AppDelegate.h
//  MySmartHome
//
//  Created by sonwa on 14-6-1.
//  Copyright (c) 2014年 SonWa. All rights reserved.
//

#import <UIKit/UIKit.h>

@class ViewController;
@class LoginViewController;

@interface AppDelegate : UIResponder <UIApplicationDelegate>

@property (strong, nonatomic) UIWindow *window;

@property (strong, nonatomic) ViewController *viewController;
@property (strong, nonatomic) LoginViewController *loginViewController;

- (void)loginSuccess;

@end
