<?php

class Hash
{
	
	/**
	 *
	 * @param string $algo The algorithm (md5, sha1, whirlpool, etc)
	 * @param string $data The data to encode
	 * @param string $key The Key to encrypt and decrypt
	 * @return string The hashed/salted data
	 */
	public static function create($data, $key = HASH_PASSWORD_KEY, $algo="SHA512")
	{
		
		$context = hash_init($algo, HASH_HMAC, $key);
		hash_update($context, $data);
		
		return hash_final($context);
		
	}
        
        public static function getSecret(Usuario $usr){
            return self::create($usr->getNombre().$usr->getId(), HASH_KEY, "MD5");
        }
        
        public static function encrypt($string, $key) {
            $result = '';
            for($i=0; $i<strlen($string); $i++) {
               $char = substr($string, $i, 1);
               $keychar = substr($key, ($i % strlen($key))-1, 1);
               $char = chr(ord($char)+ord($keychar));
               $result.=$char;
            }
            return base64_encode($result);
        }

        public static function decrypt($string, $key) {
            $result = '';
            $string = base64_decode($string);
            for($i=0; $i<strlen($string); $i++) {
               $char = substr($string, $i, 1);
               $keychar = substr($key, ($i % strlen($key))-1, 1);
               $char = chr(ord($char)-ord($keychar));
               $result.=$char;
            }
            return $result;
         }
         
         public static function validateKey($key){
             $providedK = Hash::decrypt($key, HASH_SECRET);
             if($providedK == SECRET_WORD){
                 return true;
             }else{
                 return false;
             }
         }
        
}