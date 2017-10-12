//
//  JgqAes.h
//  xxxxx
//
//  Created by jinguoqiang on 2017/10/12.
//  Copyright © 2017年 jinguoqiang. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface JgqAes : NSObject

+(NSString *)AES128Encrypt:(NSString *)plainText withKey:(NSString *)key;
+(NSString *)AES128Decrypt:(NSString *)encryptText withKey:(NSString *)key;

@end
