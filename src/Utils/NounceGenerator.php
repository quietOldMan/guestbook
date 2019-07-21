<?php


namespace Guestbook\Utils;


class NounceGenerator
{
    /** @var String|null */
    private $nonce;

    /**
     * Generates a random nonce parameter.
     *
     * @return string
     * @throws \Exception
     */
    public function getNonce(): String
    {
        // generation occurs only when $this->nonce is still null
        if (!$this->nonce) {
            $this->nonce = base64_encode(random_bytes(20));
        }
        return $this->nonce;
    }
}