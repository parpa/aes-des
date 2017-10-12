//
//  JgqAes.m
//  xxxxx
//
//  Created by jinguoqiang on 2017/10/12.
//  Copyright © 2017年 jinguoqiang. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CommonCrypto/CommonDigest.h>
#import <CommonCrypto/CommonCryptor.h>

#import "JgqAes.h"

@implementation JgqAes

+(NSString *)AES128Encrypt:(NSString *)plainText withKey:(NSString *)key
{
    NSData* data = [plainText dataUsingEncoding:NSUTF8StringEncoding];
    NSUInteger dataLength = [data length];
    // 当数据位数正好够的时候，就再补充一组，这样保证绝对有填充
    int diff = kCCBlockSizeAES128 - (dataLength % kCCBlockSizeAES128);
    // 输入字符自己进行0填充，因为aes是块加密，所以先按块长度把长度补充完整
    unsigned long newSize = dataLength + diff;
    void *dataPtr = malloc(newSize);
    // 先0填充
    bzero(dataPtr, newSize);
    // 再拷贝数据
    memcpy(dataPtr, [data bytes], [data length]);
    
    size_t bufferSize = newSize + kCCBlockSizeAES128;
    void *buffer = malloc(bufferSize);
    memset(buffer, 0, bufferSize);
    
    size_t numBytesCrypted = 0;
    
    CCCryptorStatus cryptStatus = CCCrypt(kCCEncrypt,
                                          kCCAlgorithmAES128,
                                          kNilOptions, // 这里不再填充，默认为 cbc 向量模式
                                          [key UTF8String],
                                          kCCKeySizeAES128,
                                          [key UTF8String],
                                          dataPtr,
                                          newSize,
                                          buffer,
                                          bufferSize,
                                          &numBytesCrypted);
    
    if (cryptStatus == kCCSuccess) {
        NSData *resultData = [NSData dataWithBytesNoCopy:buffer length:numBytesCrypted];
        return [resultData base64EncodedStringWithOptions:kNilOptions];
    }
    free(dataPtr);
    free(buffer);
    return nil;
}

+(NSString *)AES128Decrypt:(NSString *)encryptText withKey:(NSString *)key
{
    NSData *data = [[NSData alloc] initWithBase64EncodedString:encryptText options:kNilOptions];
    NSUInteger dataLength = [data length];
    size_t bufferSize = dataLength + kCCBlockSizeAES128;
    void *buffer = malloc(bufferSize);
    bzero(buffer, bufferSize);
    size_t numBytesCrypted = 0;
    CCCryptorStatus cryptStatus = CCCrypt(kCCDecrypt,
                                          kCCAlgorithmAES128,
                                          kNilOptions,
                                          [key UTF8String],
                                          kCCBlockSizeAES128,
                                          [key UTF8String],
                                          [data bytes],
                                          dataLength,
                                          buffer,
                                          bufferSize,
                                          &numBytesCrypted);
    if (cryptStatus == kCCSuccess) {
        // 注意：这里默认传输字符串为全可见字符，不会出现多余的 \0 \20 之内的空白字符
        NSString *decoded = [NSString stringWithUTF8String:buffer];
        return decoded;
    }
    
    free(buffer);
    return nil;
}

@end
