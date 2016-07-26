<?php

declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint;

use PurpleBooth\GitGitHubLint\Status\Status;

/**
 * A commit message
 *
 * @package PurpleBooth\GitGitHubLint
 */
class MessageImplementation implements Message
{
    /**
     * @var array
     */
    private $commitMessage;

    /**
     * @var string
     */
    private $sha;

    /**
     * @var Status
     */
    private $status;

    /**
     * Message constructor.
     *
     * @param string $sha
     * @param string $commitMessage
     */
    public function __construct(string $sha, string $commitMessage)
    {
        $this->commitMessage = explode("\n", $commitMessage);
        $this->sha           = $sha;
    }

    /**
     * Is the title capitalised
     *
     * @return bool
     */
    public function isTitleCapitalised() : bool
    {
        if ($this->getTitleLength() == 0) {
            return false;
        }

        return strtoupper($this->commitMessage[0]){0} === $this->commitMessage[0]{0};
    }

    /**
     * Get the title length
     *
     * @return int
     */
    public function getTitleLength() : int
    {
        return strlen($this->commitMessage[0]);
    }

    /**
     * Title ends with a full stop
     *
     * @return bool
     */
    public function hasTitleAFullStop() : bool
    {
        if ($this->getTitleLength() == 0) {
            return false;
        }

        $lastCharacter = trim($this->commitMessage[0]){$this->getTitleLength() - 1};

        return $lastCharacter == ".";
    }

    /**
     * Has a gap after the title
     *
     * @return bool
     */
    public function hasBlankLineAfterTitle() : bool
    {
        if (count($this->commitMessage) < 2) {
            return false;
        }

        return $this->commitMessage[1] == "";
    }

    /**
     * Has this message got a body
     *
     * @return bool
     */
    public function hasABody(): bool
    {
        // Has a body
        if ($this->getBodyWrapLength() > 0) {
            // First line isn't long
            return strlen($this->commitMessage[2]) > 0;
        }

        return false;
    }

    /**
     * The length at which the message wraps
     *
     * @return int
     */
    public function getBodyWrapLength() : int
    {
        if (count($this->commitMessage) < 3) {
            return 0;
        }

        $body              = array_slice($this->commitMessage, 2);
        $longestLineLength = 0;

        foreach ($body as $line) {
            if (strlen($line) > $longestLineLength) {
                $longestLineLength = strlen($line);
            }
        }

        return $longestLineLength;
    }

    /**
     * Get the SHA that identifies this commit
     *
     * @return string
     */
    public function getSha() : string
    {
        return $this->sha;
    }

    /**
     * Get the status associated with this message
     *
     * @return Status
     */
    public function getStatus() : Status
    {
        return $this->status;
    }

    /**
     * Associate a status with this message
     *
     * @param Status $status
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
    }
}
