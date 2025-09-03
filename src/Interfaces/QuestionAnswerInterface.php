<?php

namespace Partitech\PhpMistral\Interfaces;

interface QuestionAnswerInterface
{
    public function getAnswer(): ?string;
    public function setAnswer(string $answer): static;
    public function getQuestion(): ?string;
    public function setQuestion(string $question): static;
}