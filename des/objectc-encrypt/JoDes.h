//
//  JoDes.h
//  crypt
//
//  Created by jinguoqiang on 2015/10/15.
//  Copyright © 2015年 jinguoqiang. All rights reserved.
//

#ifndef JoDes_h
#define JoDes_h

/***  JoDes.h ***/

#import <Foundation/Foundation.h>
#import <CommonCrypto/CommonDigest.h>
#import <CommonCrypto/CommonCryptor.h>

@interface JoDes : NSObject

+ (NSString *) encode:(NSString *)str key:(NSString *)key;
+ (NSString *) decode:(NSString *)str key:(NSString *)key;

+ (NSMutableString *)urlEncode:(NSString*)str;
+ (NSString *)urlDecode:(NSString*)str;

@end

#endif /* JoDes_h */
