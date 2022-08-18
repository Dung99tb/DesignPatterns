<?php
/*Lớp Creator khai báo phương thức gốc được cho là trả về*/
abstract class Creator
{
    /*
    *Lưu ý rằng Người tạo cũng có thể cung cấp một số triển khai mặc định của phương pháp
    */
    abstract public function factoryMethod(): Product;
    public function someOperation(): string
    {
        //Gọi phương thức factory để tạo một đối tượng Sản phẩm.
        $product = $this->factoryMethod();
        // Now, use the product.
        $result = "Creator:Cùng một mã của creator vừa làm việc với " .
            $product->operation();

        return $result;
    }
}
/*Concrete Creators ghi đè phương thức factory để thay đổi loại kết quả sản phẩm.*/
class ConcreteCreator1 extends Creator
{
    public function factoryMethod(): Product
    {
        return new ConcreteProduct1();
    }
}
class ConcreteCreator2 extends Creator
{
    public function factoryMethod(): Product
    {
        return new ConcreteProduct2();
    }
}
/**
* Giao diện Sản phẩm khai báo các hoạt động mà tất cả các sản phẩm cụ thể phải
* thực hiện.
*/
interface Product
{
    public function operation(): string;
}
class ConcreteProduct1 implements Product
{
    public function operation(): string
    {
        return "{Result of the ConcreteProduct1}";
    }
}

class ConcreteProduct2 implements Product
{
    public function operation(): string
    {
        return "{Result of the ConcreteProduct2}";
    }
}
function clientCode(Creator $creator)
{
    // ...
    echo "Client: Tôi không biết về lớp của người sáng tạo, nhưng nó vẫn hoạt động.<br/>"
        . $creator->someOperation();
    // ...
}
echo "App: Launched with the ConcreteCreator1.<br/>";
clientCode(new ConcreteCreator1());
echo "<br/><br/>";

echo "App: Launched with the ConcreteCreator2.<br/>";
clientCode(new ConcreteCreator2());
