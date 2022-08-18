<?php
/**
 * Bài toán thực tế:
 * Hãy tưởng tượng rằng bạn phải đến sân bay. Bạn có thể bắt xe buýt, đặt taxi hoặc đi xe đạp.
 * Đây là những strategy vận chuyển của bạn. Bạn có thể chọn một trong các strategy tùy thuộc vào các yếu tố
 * như hạn chế về ngân sách hoặc thời gian.
 */
class Context
{
    /**
     * Context duy trì tham chiếu đến một trong các Strategy các đối tượng. 
     * Context không biết lớp cụ thể của một Strategy.
     * Nó nên hoạt động với tất cả các strategy thông qua Strategy Interface.
     */
    private $strategy;
    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }
    public function setStrategy(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }
    /**
     * Context ủy quyền một số công việc cho đối tượng Strategy thay vì
     * Tự thực hiện nhiều phiên bản của thuật toán.
     */
    public function doSomeBusinessLogic(): void
    {
        // ...

        echo "Context: Sắp xếp dữ liệu bằng cách sử dụng strategy <br/>";
        $result = $this->strategy->doAlgorithm(["a", "b", "c", "d", "e"]);
        echo implode(",", $result) . "<br/>";

        // ...
    }
    
}
/**
     * Giao diện strategy khai báo các hoạt động phổ biến cho tất cả các phiên bản được hỗ trợ
     * của một số thuật toán.
     * Context sử dụng giao diện này để gọi thuật toán được xác định bởi Concrete Strategies
     */
interface Strategy
{
    public function doAlgorithm(array $data): array;
}
class ConcreteStrategyA implements Strategy
{
    public function doAlgorithm(array $data): array
    {
        sort($data);

        return $data;
    }
}

class ConcreteStrategyB implements Strategy
{
    public function doAlgorithm(array $data): array
    {
        rsort($data);

        return $data;
    }
}
/**
 * Chọn một strategy cụ thể và chuyển nó vào context.
 */
$context = new Context(new ConcreteStrategyA());
echo "Client: Strategy được đặt thành sắp xếp bình thường..<br/>";
$context->doSomeBusinessLogic();

echo "<br/>";

echo "Client: Strategy được đặt thành sắp xếp ngược.<br/>";
$context->setStrategy(new ConcreteStrategyB());
$context->doSomeBusinessLogic();