<?php

/**
 * JWTiny
 * v1.0
 * https://github.com/ginger-tek/jwtiny
 */

class JWTiny
{
  static function sign(mixed $data, string $secret, ?int $exp = null)
  {
    $payload = ['data' => $data, 'exp' => $exp ?? time() + 60000, 'iat' => time()];
    $b64header = base64_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
    $b64payload = base64_encode(json_encode($payload));
    $b64sig = base64_encode(hash_hmac('sha256', "$b64header.$b64payload", $secret, true));
    return "$b64header.$b64payload.$b64sig";
  }

  static function verify(string $jwt, string $secret)
  {
    try {
      $tokenParts = explode('.', $jwt);
      $header = base64_decode($tokenParts[0]);
      $payload = base64_decode($tokenParts[1]);
      $data = json_decode($payload);
      $signature = $tokenParts[2];
      if (time() > $data->exp) return false;
      $b64sig = base64_encode(hash_hmac('sha256', base64_encode($header) . '.' . base64_encode($payload), $secret, true));
      if ($signature === $b64sig) return $data;
      return false;
    } catch (Exception $e) {
      return false;
    }
  }

  static function genKey()
  {
    return bin2hex(random_bytes(32));
  }
}
