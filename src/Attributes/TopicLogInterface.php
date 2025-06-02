<?php

namespace Ulugov\MonologTelegram\Attributes;

interface TopicLogInterface
{
    public function getTopicID(array $topicsLevel): string|null;
}
