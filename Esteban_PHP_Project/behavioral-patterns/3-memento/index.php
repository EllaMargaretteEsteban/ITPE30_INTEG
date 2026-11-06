
<?php

class StudentProfileMemento {
    public function __construct(
        private string $name,
        private string $program,
        private int $year,
        private string $email
    ) {
    }

    public function getState(): array {
        return [
            'name' => $this->name,
            'program' => $this->program,
            'year' => $this->year,
            'email' => $this->email
        ];
    }
}

class StudentProfile {
    private string $name;
    private string $program;
    private int $year;
    private string $email;

    public function __construct(
        string $name,
        string $program,
        int $year,
        string $email
    ) {
        $this->name = $name;
        $this->program = $program;
        $this->year = $year;
        $this->email = $email;
    }

    public function save(): StudentProfileMemento {
        return new StudentProfileMemento(
            $this->name,
            $this->program,
            $this->year,
            $this->email
        );
    }

    public function restore(StudentProfileMemento $memento): void {
        $state = $memento->getState();

        $this->name = $state['name'];
        $this->program = $state['program'];
        $this->year = $state['year'];
        $this->email = $state['email'];
    }

    public function change(
        string $name,
        string $program,
        int $year,
        string $email
    ): void {
        $this->name = $name;
        $this->program = $program;
        $this->year = $year;
        $this->email = $email;
    }

    public function show(): void {
        echo "Name: " . $this->name . "\n";
        echo "Program: " . $this->program . "\n";
        echo "Year: " . $this->year . "\n";
        echo "Email: " . $this->email . "\n";
    }
}

class ProfileHistory {
    private array $history = [];

    public function push(StudentProfileMemento $memento): void {
        $this->history[] = $memento;
    }

    public function undo(StudentProfile $profile): void {
        $previous = array_pop($this->history);

        if ($previous) {
            $profile->restore($previous);
        }
    }
}

// Main Program

$profile = new StudentProfile(
    'Juan',
    'ITBAN',
    2,
    'juan@example.com'
);

$history = new ProfileHistory();

$history->push($profile->save());

$profile->change(
    'Maria',
    'ITBAN',
    3,
    'pedro@example.com'
);

$history->push($profile->save());

$profile->change(
    'Ken',
    'ITBAN',
    4,
    'maria@example.com'
);
echo "Current Profile:\n";
$profile->show();
echo "\nAfter Undo:\n";
$history->undo($profile);
$profile->show();
?>