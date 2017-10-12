//
//  NSData+Compression.h
//  crypt
//
//  Created by jinguoqiang on 2015/10/15.
//  Copyright © 2015年 jinguoqiang. All rights reserved.
//

#import <Foundation/Foundation.h>

#import <Foundation/NSData.h>

/*! Adds compression and decompression messages to NSData.
 * Methods extracted from source given at
 * http://www.cocoadev.com/index.pl?NSDataCategory
 */
@interface NSData (Compression)

#pragma mark -
#pragma mark Gzip Compression routines
/*! Returns a data object containing a Gzip decompressed copy of the receivers contents.
 * \returns A data object containing a Gzip decompressed copy of the receivers contents.
 */
- (NSData *) gzipInflate;
/*! Returns a data object containing a Gzip compressed copy of the receivers contents.
 * \returns A data object containing a Gzip compressed copy of the receivers contents.
 */
- (NSData *) gzipDeflate;


@end
