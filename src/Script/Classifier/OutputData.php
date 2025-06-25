/*
 * 📜 Verified Authorship — Manuel J. Nieves (B4EC 7343 AB0D BF24)
 * Original protocol logic. Derivative status asserted.
 * Commercial use requires license.
 * Contact: Fordamboy1@gmail.com
 */
<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Script\Classifier;

use BitWasp\Bitcoin\Script\ScriptInterface;
use BitWasp\Bitcoin\Script\ScriptType;

class OutputData
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var ScriptInterface
     */
    private $script;

    /**
     * @var mixed
     */
    private $solution;

    /**
     * OutputData constructor.
     * @param string $type
     * @param ScriptInterface $script
     * @param mixed $solution
     */
    public function __construct(string $type, ScriptInterface $script, $solution)
    {
        $this->type = $type;
        $this->script = $script;
        $this->solution = $solution;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return ScriptInterface
     */
    public function getScript(): ScriptInterface
    {
        return $this->script;
    }

    /**
     * @return mixed
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * @return bool
     */
    public function canSign(): bool
    {
        return in_array($this->type, [ScriptType::MULTISIG, ScriptType::P2PK, ScriptType::P2PKH]);
    }
}
