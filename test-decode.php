<?php
$token = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjcwZmM5YzU0YjhiMjQyMWZmMTgyOTgxNTQyZmQ0NjRlOWJlYzM1NDUiLCJ0eXAiOiJKV1QifQeyJuYW1lIjoiTXXFi2FYxK9yIMaBYW5nYcWfaCIsInBpY3R1cmUiOiJodHRwczovL2dyYXBoLmZhY2Vib29rLmNvbS80MzE3NTgxMTgxODg2OTYxL3BpY3R1cmUiLCJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vb3ZhdGlmeS1mZjdhMyIsImF1ZCI6Im92YXRpZnktZmY3YTMiLCJhdXRoX3RpbWUiOjE3NzYzMjMzODIsInVzZXJfaWQiOiJkSndjNTl2NFFraGV1R0xUVWJRWWdjTWZsNzEzIiwic3ViIjoiZEp3YzU5djRRa2hldUdMVFViUVlnY01mbDcxMyIsImlhdCI6MTc3NjMyMzM4NCwiZXhwIjoxNzc2MzI2OTg0LCJmaXJlYmFzZSI6eyJpZGVudGl0aWVzIjp7ImZhY2Vib29rLmNvbSI6WyI0MzE3NTgxMTgxODg2OTYxIl19LCJzaWduX2luX3Byb3ZpZGVyIjoiZmFjZWJvb2suY29tIn19cTy0ZK-FNrCkECWfF2zC2AsKvubWMmrHzDEBHKhqdAmvU3R0R85Qo3zdDOeo4jPXBf2q_Ayhd5yvoavMrojw6_XijyYfv7GuFMImx81fa6GTUt6yzgGpzOsqzKL1IsRaHbpQbKTcKhJfLHdrcuLayp2ywVY5UWQ6G7QsalXb0IcylKT4WbVWWTiVaxThNGXxK1ZnefVsPr7JSHdDfRnagEWcf6ymK9-zYJ6R5iNFpQEtJKCMpSzOkPNriv6BQaWCZIUkduHiXmksaCBLV-YMjfPOojWc7jvV4nZTlPnbyW5uIn6W2kYv0F-kumm3UQplSyjH8CirUuiCSlF7PV0GRA";

function extractPayload($token) {
    if (strpos($token, '.') !== false) {
        $parts = explode('.', $token);
        if (count($parts) === 3) return json_decode(base64_decode($parts[1]), true);
    }
    
    // Fallback for concatenated (dot-less) tokens
    // JWT header usually ~100 chars, payload starts with eyJ.
    // Let's find all occurrences of eyJ
    $offset = 0;
    while (($pos = strpos($token, 'eyJ', $offset)) !== false) {
        $offset = $pos + 3;
        // The payload ends where the signature starts. 
        // We can just try to decode progressively longer chunks.
        // Actually, since payload is valid JSON, let's find the closing brace.
        // It's easier: just try to decode the substring from $pos to the end, 
        // taking off 1 character from the end at a time until base64_decode -> json_decode works!
        // But since base64 padding is absent, base64_decode ignores invalid chars at the end?
        // Let's just grab the substring from $pos, and cut characters from the end.
        $substr = substr($token, $pos);
        for ($i = strlen($substr); $i > 10; $i--) {
            $chunk = substr($substr, 0, $i);
            // base64_decode requires modulo 4 length
            $pad = strlen($chunk) % 4;
            $padded = $chunk . str_repeat('=', $pad == 0 ? 0 : 4 - $pad);
            $decoded = base64_decode($padded, true);
            if ($decoded && substr($decoded, 0, 1) === '{' && substr($decoded, -1) === '}') {
                $json = json_decode($decoded, true);
                if ($json && (isset($json['user_id']) || isset($json['sub']))) {
                    return $json;
                }
            }
        }
    }
    return null;
}

$payload = extractPayload($token);
var_dump($payload);
