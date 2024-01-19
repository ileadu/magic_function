<?php

class Address
{

    public function __construct(
        public string $street,
        protected string $city,
        private readonly string $state,
        private ?int $zip = null,
        private readonly string $type = 'address'
    ) {
        $this->connect();
        $this->dump('Open connection');
    }

    public function __invoke(): void
    {
        $this->dump('Address object is called as a function!');
        $args = func_get_args();
        if ($args) {
            echo '$args[0]: ' . $args[0] . PHP_EOL;
        }
    }

    public function __get(string $name): mixed
    {
        $this->dump("Address `$name` property was retrieve using __get");
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->dump("Address `$name` property was __set to: `$value`");
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function __isset(string $name): bool
    {
        $this->dump("Address `$name` property checked if __isset");
        return isset($this->$name);
    }

    public function __unset(string $name): void
    {
        $this->dump("Address `$name` property was __unset");
        $this->{$name} = null;
    }

    public function __toString(): string
    {
        $this->dump("Address properties were returned as string using __toString");
        return "{$this->type}: {$this->street}, {$this->city}, {$this->state}, {$this->zip}.";
    }

    public function __clone(): void
    {
        $this->dump('Address object called __clone');
        trigger_error('Cloning forbidden.', E_USER_WARNING);
    }

    public function __sleep(): array
    {
        $this->dump('Address attributes to serialize, called __sleep');
        return ['street', 'zip', 'city', 'state', 'type'];
    }

    public function __wakeup(): void
    {
        $this->dump('Reconnect to DB __wakeup');
        $this->connect();
    }

    public function __destruct()
    {
        $this->dump('Close connection to DB and do other cleanups');
        $this->closeConnection();
    }

    public function __call(string $name, mixed $arguments): mixed
    {
        $this->dump("Calling object method '$name' " . implode(', ', $arguments));
        if ($name === 'format') {
            return $this->displayAddress();
        }
    }

    public static function __callStatic(string $name, mixed $arguments): ?Address
    {
        self::sdump("Calling static method '$name' " . implode(', ', $arguments));
        if ($name === 'getDefaultAddress') {
            return new Address('板橋區文化路二段', '新北市', '台灣', 220);
        }
    }

    private function connect(): void
    {
        $this->dump('Connect to DB');
    }

    private function closeConnection(): void
    {
        $this->dump('Close connection to DB');
    }

    public function displayAddress(): string
    {
        return "{$this->street}, {$this->city}, {$this->state}";
    }

    private function dump(string $message): void
    {
        $functionName = debug_backtrace()[1]['function'];
        echo "[$functionName] $message" . PHP_EOL;
    }

    private static function sdump(string $message): void
    {
        $functionName = debug_backtrace()[1]['function'];
        echo "[$functionName] $message" . PHP_EOL;
    }

}