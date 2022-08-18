<?php
interface Component
{
    public function operation(): string;
}
/**
 * Concrete Components cung cấp các triển khai mặc định của các hoạt động
 */
class ConcreteComponent implements Component
{
    public function operation(): string
    {
        return "ConcreteComponent";
    }
}
/**
 * Mục đích chính của lớp này là xác định giao diện gói cho tất cả concrete decorators.
 * Việc triển khai mặc định của mã gói có thể bao gồm một trường để lưu trữ một thành phần được bao bọc
 * và phương tiện để khởi tạo nó
 */
class Decorator implements Component
{
    
    protected $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    /**
     * Các ủy quyền của Decorator đều hoạt động đối với thành phần được bao bọc..
     */
    public function operation(): string
    {
        return $this->component->operation();
    }
}
/**
 * Concrete Decorator gọi đối tượng được bọc và thay đổi kết quả của nó theo một cách nào đó.
 */
class ConcreteDecoratorA extends Decorator
{
    /**
     * Decorators có thể gọi hoạt động triển khai cha mẹ, thay vì
     * gọi trực tiếp đối tượng được bọc. Cách tiếp cận này đơn giản hóa việc mở rộng
     * của các lớp trang trí.
     */
    public function operation(): string
    {
        return "ConcreteDecoratorA(" . parent::operation() . ")";
    }
}
class ConcreteDecoratorB extends Decorator
{
    public function operation(): string
    {
        return "ConcreteDecoratorB(" . parent::operation() . ")";
    }
}
function clientCode(Component $component)
{
    // ...

    echo "RESULT: " . $component->operation();

    // ...
}

/**
 * Bằng cách này, mã máy khách có thể hỗ trợ cả hai thành phần đơn giản ...
 */
$simple = new ConcreteComponent();
echo "Client: Tôi có một thành phần đơn giản:<br/>";
clientCode($simple);
"ConcreteComponent";
echo "<br/><br/>";

$decorator1 = new ConcreteDecoratorA($simple);
$decorator2 = new ConcreteDecoratorB($decorator1);
echo "Client: Bây giờ tôi đã có một thành phần được trang trí:<br/>";
clientCode($decorator2);
"ConcreteComponent(ConcreteComponentA(ConcreteComponentB))";

