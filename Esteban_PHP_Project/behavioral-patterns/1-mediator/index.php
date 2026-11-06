<?php
interface Mediator {
    public function send (string $message, Student $sender): void;
}
class ChatMediator implements Mediator{
    private array $students = [];
    public function addStudent (Student $student): void {
        $this->students[] = $student;
    }
    public function send (string $message, Student $sender): void {
        echo $sender->getName().": ".$message."\n";
    
            foreach ($this->students as $student) {
                if ($student !== $sender) {
                    $student->receive($message);
                }
    }
}
}

class Student {
    private string $name;
    private Mediator $mediator;

    public function __construct (string $name, Mediator $mediator) {
        $this->name = $name;
        $this->mediator = $mediator;
    }

    public function getName(): string {
        return $this->name;
    }
    public function send (string $message): void {
        $this->mediator->send($message, $this);
    }
    public function receive (string $message): void {
        echo $this->name. " received: ".$message."\n";
    }

}

$chat = new ChatMediator();

$juan = new Student ('Juan', $chat);
$maria = new Student ('Maria', $chat);
$ken = new Student ('Ken', $chat);

foreach ([$juan, $maria, $ken] as $student) {
    $student->send("Hello everyone!");
}

$juan->send("Hi Friends!");

?>