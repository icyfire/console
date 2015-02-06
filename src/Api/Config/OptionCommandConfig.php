<?php

/*
 * This file is part of the webmozart/console package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webmozart\Console\Api\Config;

use Webmozart\Console\Assert\Assert;

/**
 * The configuration of an option command.
 *
 * @since  1.0
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class OptionCommandConfig extends SubCommandConfig
{
    /**
     * @var string
     */
    private $shortName;

    /**
     * Creates a new configuration.
     *
     * @param string            $name              The long option name of the command.
     * @param string            $shortName         The short option name of the command.
     * @param CommandConfig     $parentConfig      The parent configuration.
     * @param ApplicationConfig $applicationConfig The application configuration.
     */
    public function __construct($name = null, $shortName = null, CommandConfig $parentConfig = null, ApplicationConfig $applicationConfig = null)
    {
        parent::__construct($name, $parentConfig, $applicationConfig);

        $this->setShortName($shortName);
    }

    /**
     * Sets the name of the command.
     *
     * Contrary to the base implementation, the name of an option command must
     * contain at least two characters.
     *
     * @param string $name The name of the command.
     *
     * @return static The current instance.
     */
    public function setName($name)
    {
        if (null !== $name) {
            Assert::string($name, 'The command name must be a string or null. Got: %s');
            Assert::notEmpty($name, 'The command name must not be empty.');
            Assert::greaterThan(strlen($name), 1, sprintf('The command name should contain at least two characters. Got: "%s"', $name));
        }

        parent::setName($name);
    }

    /**
     * Returns the short option name of the command.
     *
     * @return string The short option name.
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Sets the short option name of the command.
     *
     * The short name must consist of a single letter. The short name is
     * preceded by a single dash "-" when calling the command:
     *
     * ```
     * $ server -d localhost
     * ```
     *
     * In the example above, "d" is the short name of the "server --delete"
     * command.
     *
     * @param string $shortName The short option name.
     *
     * @return static The current instance.
     */
    public function setShortName($shortName)
    {
        if (null !== $shortName) {
            Assert::string($shortName, 'The short command name must be a string or null. Got: %s');
            Assert::notEmpty($shortName, 'The short command name must not be empty.');
            Assert::regex($shortName, '~^[a-zA-Z]$~', 'The short command name must contain a single letter. Got: %s');
        }

        $this->shortName = $shortName;

        return $this;
    }
}