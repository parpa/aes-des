const zlib = require('zlib');
const crypto = require('crypto');
const ivHexLength = 16; // 2*8
const makeiv = () => {
  let text = "";
  const possible = "abcdef9876543210";

  for (let i = 0; i < ivHexLength; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
};

// DES 加密;
const PARAM_DESENCRYPT = (message, key) => {
  key = key.length >= 8 ? key.slice(0, 8) : key.concat('0'.repeat(8 - key.length));
  const keyHex = new Buffer(key);
  const iv = makeiv();
  message = encodeURIComponent(message);

  const cipher = crypto.createCipheriv('des-cbc', keyHex, new Buffer(iv, 'hex'));
  cipher.setAutoPadding(true);
  message = cipher.update(message, 'utf8', 'hex');
  message += cipher.final('hex');
  message = iv+message;
  
  message = zlib.deflateRawSync(new Buffer(message, "hex"), {level: zlib.Z_BEST_COMPRESSION});
  message = message.toString('base64');
  message = encodeURIComponent(message);
  
  // let text = PARAM_DESDECRYPT(message, key);
  
  return message;
};

// DES 解密;
const PARAM_DESDECRYPT = (text, key) => {
  key = key.length >= 8 ? key.slice(0, 8) : key.concat('0'.repeat(8 - key.length));
  const keyHex = new Buffer(key);
  text = decodeURIComponent(text);
  // decodeURIComponent((str + '')
  //   .replace(/%(?![\da-f]{2})/gi, function () {
  //     // PHP tolerates poorly formed escape sequences
  //     return '%25';
  // }));
  buffer = zlib.inflateRawSync(new Buffer(text, "base64"));
  text = buffer.toString('hex');
  const iv = text.substr(0, ivHexLength);
  text = text.substr(ivHexLength);
  // console.log('text:', text, 'iv:', iv);
  const cipher = crypto.createDecipheriv('des-cbc', keyHex, new Buffer(iv, 'hex'));
  cipher.setAutoPadding(true);
  text = cipher.update(text, 'hex');
  text += cipher.final('utf8');
  // console.log('decodeURI', text);
  text = decodeURIComponent(text);
  // console.log(text);
  return text;
};