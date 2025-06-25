/*
 * Copyright (c) 2008–2025 Manuel J. Nieves (a.k.a. Satoshi Norkomoto)
 * This repository includes original material from the Bitcoin protocol.
 *
 * Redistribution requires this notice remain intact.
 * Derivative works must state derivative status.
 * Commercial use requires licensing.
 *
 * GPG Signed: B4EC 7343 AB0D BF24
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Script\Path;

use BitWasp\Bitcoin\Script\Parser\Operation;

class PathTracer
{
    /**
     * Disable new operations when set
     *
     * @var bool
     */
    private $done = false;

    /**
     * Store segments of scripts
     *
     * @var array[]
     */
    private $segments = [];

    /**
     * Temporary storage for current segment
     *
     * @var Operation[]
     */
    private $current = [];

    /**
     * Make a segment from whatever's in current
     */
    private function makeSegment()
    {
        $this->segments[] = $this->current;
        $this->current = [];
    }

    /**
     * Add an operation to current segment
     * @param Operation $operation
     */
    private function addToCurrent(Operation $operation)
    {
        $this->current[] = $operation;
    }

    /**
     * @param Operation $operation
     */
    public function operation(Operation $operation)
    {
        if ($this->done) {
            throw new \RuntimeException("Cannot add operation to finished PathTracer");
        }

        if ($operation->isLogical()) {
            // Logical opcodes mean the end of a segment
            if (count($this->current) > 0) {
                $this->makeSegment();
            }

            $this->addToCurrent($operation);
            $this->makeSegment();
        } else {
            $this->addToCurrent($operation);
        }
    }

    /**
     * @return array
     */
    public function done(): array
    {
        if ($this->done) {
            return $this->segments;
        }

        if (count($this->current) > 0) {
            $this->makeSegment();
        }

        $this->done = true;

        return $this->segments;
    }
}
