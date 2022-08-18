<?php
/**
 * Bài toán thực tế:
 * Khi vào nhà hàng và đặt món, người phục vụ thân thiện tiếp cận bạn và nhanh chóng nhận đơn đặt hàng của bạn, viết nó ra một tờ giấy.
 * Người phục vụ đi vào bếp và dán thứ tự lên tường. Sau một thời gian, đơn đặt hàng được chuyển đến đầu bếp,
 * người sẽ đọc và nấu bữa ăn cho phù hợp. 
 */
interface Command
{
    public function execute(): void;
}
class SimpleCommand implements Command
{
    private $payload;

    public function __construct(string $payload)
    {
        $this->payload = $payload;
    }

    public function execute(): void
    {
        echo "SimpleCommand: Thấy chưa, tôi có thể làm những việc đơn giản như in(" . $this->payload . ")<br/>";
    }
}
class ComplexCommand implements Command
{
    private $receiver;

    private $a;

    private $b;

    public function __construct(Receiver $receiver, string $a, string $b)
    {
        $this->receiver = $receiver;
        $this->a = $a;
        $this->b = $b;
    }

    public function execute(): void
    {
        echo "ComplexCommand: Những thứ phức tạp nên được thực hiện bởi một đối tượng receiver.<br/>";
        $this->receiver->doSomething($this->a);
        $this->receiver->doSomethingElse($this->b);
    }
}
/**
 * Các lớp Receiver chứa một số logic nghiệp vụ quan trọng. Trong
 * thực tế, bất kỳ lớp nào cũng có thể đóng vai trò là receiver.
 */
class Receiver
{
    public function doSomething(string $a): void
    {
        echo "Receiver: Đang làm việc (" . $a . ".)<br/>";
    }

    public function doSomethingElse(string $b): void
    {
        echo "Receiver: Cũng đang làm việc (" . $b . ".)<br/>";
    }
}
/**
 * Invoker được liên kết với một hoặc một số lệnh. Nó gửi một yêu cầu đến lệnh.
 */
class Invoker
{
    private $onStart;
    private $onFinish;
    public function setOnStart(Command $command): void
    {
        $this->onStart = $command;
    }

    public function setOnFinish(Command $command): void
    {
        $this->onFinish = $command;
    }
    /**
     * Invoker không phụ thuộc vào lệnh cụ thể hoặc các lớp nhận. Các Invoker chuyển một yêu cầu đến người nhận
     *  một cách gián tiếp, bằng cách thực hiện yêu cầu.
     */
    public function doSomethingImportant(): void
    {
        echo "Invoker: Có ai muốn làm điều gì đó trước khi tôi bắt đầu không?<br/>";
        if ($this->onStart instanceof Command) {
            $this->onStart->execute();
        }

        echo "Invoker: ... đang làm điều gì đó thực sự quan trọng ...<br/>";

        echo "Invoker: Có ai muốn một cái gì đó được hoàn thành sau khi tôi hoàn thành không?<br/>";
        if ($this->onFinish instanceof Command) {
            $this->onFinish->execute();
        }
    }
}
/**
 * Mã máy khách có thể tham số hóa một invoker bằng bất kỳ lệnh nào
 */
$invoker = new Invoker();
$invoker->setOnStart(new SimpleCommand("Say Hi!"));
$receiver = new Receiver();
$invoker->setOnFinish(new ComplexCommand($receiver, "Gửi email", "Lưu báo cáo"));

$invoker->doSomethingImportant();