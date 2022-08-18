<?php
class Singleton
{
    private static $instances = [];
    private function __contructor() 
    {

    }
    /**
     * Phương thức khởi tạo của Singleton phải luôn ở chế độ riêng tư để ngăn chặn trực tiếp
     * cuộc gọi xây dựng với nhà điều hành `mới`.
     */
    protected function __clone() { }
    public function __wakeup()
    {
        throw new \Exception("Không thể hủy một Singleton.");
    }
    /*Đây là phương thức tĩnh kiểm soát quyền truy cập vào singleton
    *Việc triển khai này cho phép bạn phân lớp lớp Singleton trong khi vẫn giữ
    * chỉ một thể hiện của mỗi lớp con xung quanh.
    */
    public static function getInstance(): Singleton
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }
    /*Cuối cùng bất kỳ singleton nào cũng phải xác định một số logic có thể được thực thi trên phiên bản của nó*/
    public function someBusinessLogic()
    {
        // ...
    }
}
function clientCode()
{
    $s1 = Singleton::getInstance();
    $s2 = Singleton::getInstance();
    new Singleton();
    if ($s1 === $s2) {
        echo "Singleton hoạt động, cả hai biến đều chứa cùng một trường hợp.";
    } else {
        echo "Singleton không hoạt động, các biến chứa các phiên bản khác nhau.";
    }
}

clientCode();
