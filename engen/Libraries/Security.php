<?php namespace Engen\Libraries;

class Security
{
    /**
     * Hash cost
     * @var integer
     */
    protected $cost = 10;

    /**
     * Hash algorithm
     * @var integer
     */
    protected $algo = PASSWORD_DEFAULT;


    /**
     * Set the hash cost
     *
     * @param  integer $cost
     * @return $this
     */
    public function setCost($cost)
    {
        if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
            throw new Exception("Invalid cost value. It must be an integer bewtween 4 and 31.");
        }

        $this->cost = $cost;
        return $this;
    }


    /**
     * Set the hash algorithm
     *
     * @param  integer $algorithm
     * @return $this
     */
    public function setAlgo($algo)
    {
        if (!is_numeric($algo)) {
            throw new \Exception("Invalid algorithm. It must be one of the allowed algorithms for password_hash()");
        }

        $this->algo = $algo;
        return $this;
    }


    /**
     * Hash password
     *
     * @param  string $password
     * @return string
     */
    public function hashPassword($password)
    {
        return password_hash(
            $this->preparePassword($password),
            $this->algo,
            ['cost' => $this->cost]
        );
    }


    /**
     * Verify password hash
     *
     * @param  string $password
     * @param  string $hash
     * @return boolean
     */
    public function verifyPassword($password, $hash)
    {
        return password_verify(
            $this->preparePassword($password),
            $hash
        );
    }


    /**
     * Generate a random token
     *     Partially copied from: http://php.net/manual/en/function.random-bytes.php#118932
     *
     * @param  integer $maxLength
     * @return string
     */
    public function generateToken($maxLength = 0)
    {
        if (!is_numeric($maxLength) || $maxLength < 16) {
            $maxLength = 64;
        }

        // When generated and converted in to hex, the token will be twice
        // the size, so use half the size for generating the token.
        $length = floor($maxLength / 2);

        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }

        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        }

        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }

        throw new \Exception('Your system must support either: random_bytes, openssl_random_pseudo_bytes or mcrypt_create_iv');
    }


    /**
     * Prepare the password
     *     Making sure the password doesn't get truncated
     *
     * @param  string $password
     * @return string
     */
    protected function preparePassword($password)
    {
        // BCRYPT has a limit of 72 characters and will truncate any string that's longer.
        // Since we don't want passwords to have a max limit, or that all passwords with
        // the same first 72 characters should be equal, we need to hash the password once first.
        $password = hash('sha384', $password, true);

        // The password is now in binary. Convert it to base64 to make sure that there aren't
        // any null-bites that will stop the BCRYPT hashing
        return base64_encode($password);
    }
}
