<?php

namespace Partitech\PhpMistral\Tests;

use ArrayObject;
use Partitech\PhpMistral\Tokens;
use PHPUnit\Framework\TestCase;

class TokensTest extends TestCase
{
    public function testConstructor()
    {
        $tokens = new Tokens();
        $this->assertInstanceOf(ArrayObject::class, $tokens->getTokens());
        // Test default values
        $this->assertNull($tokens->getPrompt());
        $this->assertEmpty($tokens->getModel());
        $this->assertNull($tokens->getMaxModelLength());
    }

    public function testAddToken()
    {
        $tokenInstance = new Tokens();

        // Add tokens
        $tokenInstance->addToken(1)->addToken(2)->addToken(3);

        // Verify the tokens have been added correctly
        foreach ($tokenInstance as $value) {
            $this->assertIsInt($value);  // Ensure it is an integer
        }

        $iterator = $tokenInstance->getIterator();
        $tokensArray = iterator_to_array($iterator);
        $expectedTokens = [1, 2, 3];

        $this->assertEquals($expectedTokens, $tokensArray);

        // Test adding non-integer token
        $this->expectException(\TypeError::class);
        $tokenInstance->addToken('invalid');
    }

    public function testSetGetPrompt()
    {
        $tokenInstance = new Tokens();

        // Set a prompt
        $tokenInstance->setPrompt('test prompt');

        // Verify it has been correctly set and retrieved
        $this->assertEquals($tokenInstance->getPrompt(), 'test prompt');

        // Test with null
        $tokenInstance->setPrompt(null);
        $this->assertNull($tokenInstance->getPrompt());
    }

    public function testSetGetModel()
    {
        $tokenInstance = new Tokens();

        // Set a model
        $tokenInstance->setModel('gpt-3.5');

        // Verify it has been correctly set and retrieved
        $this->assertEquals($tokenInstance->getModel(), 'gpt-3.5');

        // Test with empty string
        $tokenInstance->setModel('');
        $this->assertEmpty($tokenInstance->getModel());
    }

    public function testSetGetMaxModelLength()
    {
        $tokenInstance = new Tokens();

        // Set a maximum model length
        $tokenInstance->setMaxModelLength(1024);

        // Verify it has been correctly set and retrieved
        $this->assertEquals($tokenInstance->getMaxModelLength(), 1024);

        // Test with invalid input
        $this->expectException(\TypeError::class);
        $tokenInstance->setMaxModelLength('invalid');

        // Test with negative value
        $tokenInstance->setMaxModelLength(-1);
        $this->assertEquals($tokenInstance->getMaxModelLength(), -1);

        // Test with null value
        $tokenInstance->setMaxModelLength(null);
        $this->assertNull($tokenInstance->getMaxModelLength());
    }

    public function testSetTokens()
    {
        $tokenInstance = new Tokens();

        // Test with empty ArrayObject
        $emptyArrayObj = new ArrayObject();
        $tokenInstance->setTokens($emptyArrayObj);

        // Verify it's an ArrayObject and is empty
        $this->assertInstanceOf(ArrayObject::class, $tokenInstance->getTokens());
        $this->assertEquals([], iterator_to_array($tokenInstance->getIterator()));

        // Test with non-empty ArrayObject
        $arrayObjWithValues = new ArrayObject([10, 20, 30]);
        $tokenInstance->setTokens($arrayObjWithValues);

        $iterator = $tokenInstance->getIterator();
        $tokensArray = iterator_to_array($iterator);

        // Verify the values
        $this->assertEquals([10, 20, 30], $tokensArray);
    }

    public function testIterator()
    {
        $tokenInstance = new Tokens();

        // Add tokens
        $tokenInstance->addToken(1)->addToken(2)->addToken(3);

        // Verify the iterator returns the correct elements
        foreach ($tokenInstance as $key => $value) {
            if($key == 0){
                $this->assertEquals($value, 1);
            }
            else if($key == 1){
                $this->assertEquals($value, 2);
            }else{
                $this->assertEquals($value, 3);
            }
        }


        // Test iterator with empty tokens
        $tokenInstance = new Tokens();
        $iterator = $tokenInstance->getIterator();
        $tokensArray = iterator_to_array($iterator);

        $this->assertEmpty($tokensArray);
    }
}