
<?php
/**
 *  Bài toán thực tế:
 *  Khi bạn gọi đến một cửa hàng để đặt hàng qua điện thoại, nhân viên tổng đài sẽ là facade của bạn
 *  đối với tất cả các dịch vụ và bộ phận của cửa hàng. Nhà điều hành cung cấp cho bạn một giao diện thoại đơn giản với
 *  hệ thống đặt hàng, cổng thanh toán và các dịch vụ giao hàng khác nhau.
 */

class Facade
{
    protected $subsystem1;

    protected $subsystem2;
    /**
     * Tùy thuộc vào nhu cầu của ứng dụng của bạn, bạn có thể cung cấp facade với
     * các đối tượng hệ thống con hiện có hoặc buộc Mặt trận tự tạo chúng.
     */
    public function __construct(
        Subsystem1 $subsystem1 = null,
        Subsystem2 $subsystem2 = null
    ) {
        $this->subsystem1 = $subsystem1 ?: new Subsystem1();
        $this->subsystem2 = $subsystem2 ?: new Subsystem2();
    }
    public function operation(): string
    {
        $result = "Facade khởi tạo hệ thống con:<br/>";
        $result .= $this->subsystem1->operation1();
        $result .= $this->subsystem2->operation1();
        $result .= "Facade ra lệnh cho các hệ thống con thực hiện hành động:<br/>";
        $result .= $this->subsystem1->operationN();
        $result .= $this->subsystem2->operationZ();

        return $result;
    }
}
class Subsystem1
{
    public function operation1(): string
    {
        return "Subsystem1: Sẵn sàng!<br/>";
    }

    public function operationN(): string
    {
        return "Subsystem1: Chạy!<br/>";
    }
}
class Subsystem2
{
    public function operation1(): string
    {
        return "Subsystem2: Chuẩn bị!<br/>";
    }

    public function operationZ(): string
    {
        return "Subsystem2: Chạy!<br/>";
    }
}
function clientCode(Facade $facade)
{

    echo $facade->operation();

}
/**
* Mã máy khách có thể có một số đối tượng của hệ thống con đã được tạo. Trong
* trường hợp này, có thể đáng giá khi khởi tạo facade bằng các đối tượng này
* thay vì để facade tạo các phiên bản mới.
*/
$subsystem1 = new Subsystem1();
$subsystem2 = new Subsystem2();
$facade = new Facade($subsystem1, $subsystem2);
clientCode($facade);