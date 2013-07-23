<?php
require_once './phpexcel/PHPExcel.php';
require_once './phpexcel/PHPExcel/IOFactory.php';

/**
 * Member_system_exporter
 *
 * @author Yuo <pors37@gmail.com>
 */
class Member_system_exporter extends CI_Driver {

    private $CI;
    
    public function __construct() 
    {
        $this->CI = & get_instance();
        $this->CI->load->model('member_model');
    }
    
    /**
     * 輸出系統的會員資料
     *
     * @access public
     * @param string $filePath
     * @param boolean $hasTitle
     * @param string $type 可傳入'Exce2007', 'CSV', 'Excel5', 'HTML', 'PDF'
     */
    public function writeMembersToExcel($filePath, $hasTitle, $type)
    {
        // 建立Excel檔案
        $objExcel = new PHPExcel();
        $worksheet = $objExcel->getActiveSheet();
        // 讀取會員資料
        $memberModels = $this->CI->member_model->get(array());
        $members = array();
        foreach ($memberModels as $memberModel) {
            $members[] = $this->model_to_member($memberModel);
        }
        // 寫入標題（如果需要的話）
        if ($hasTitle) {
            $worksheet->setCellValueByColumnAndRow(0, 1, '帳號');
            $worksheet->setCellValueByColumnAndRow(1, 1, '密碼');
            $worksheet->setCellValueByColumnAndRow(2, 1, '姓名');
            $worksheet->setCellValueByColumnAndRow(3, 1, '性別');
            $worksheet->setCellValueByColumnAndRow(4, 1, '會員層級');
            $worksheet->setCellValueByColumnAndRow(5, 1, '生日');
            $worksheet->setCellValueByColumnAndRow(6, 1, '身分證字號');
            $worksheet->setCellValueByColumnAndRow(7, 1, '電話');
            $worksheet->setCellValueByColumnAndRow(8, 1, '手機');
            $worksheet->setCellValueByColumnAndRow(9, 1, '地址');
            $worksheet->setCellValueByColumnAndRow(10, 1, '電子郵件');
            $worksheet->setCellValueByColumnAndRow(11, 1, '學制');
            $worksheet->setCellValueByColumnAndRow(12, 1, '年級');
            $worksheet->setCellValueByColumnAndRow(13, 1, '班別');
            $worksheet->setCellValueByColumnAndRow(14, 1, '學校類型');
            $worksheet->setCellValueByColumnAndRow(15, 1, '學校名稱');
            $worksheet->setCellValueByColumnAndRow(16, 1, '學校地址');
            $worksheet->setCellValueByColumnAndRow(17, 1, '學校電話');
            $worksheet->setCellValueByColumnAndRow(18, 1, '縣市');
            $worksheet->setCellValueByColumnAndRow(19, 1, '單位');
        }
        // 將會員資料寫入至Excel檔案
        foreach ($members as $memberIndex => $member) {
            $rowIndex = $hasTitle ? $memberIndex + 2 : $memberIndex + 1; // $memberIndex is 0-based. Worksheet is 1-based.
            $worksheet->setCellValueByColumnAndRow(0, $rowIndex, $member->username);
            $worksheet->setCellValueByColumnAndRow(1, $rowIndex, $member->password);
            $worksheet->setCellValueByColumnAndRow(2, $rowIndex, $member->name);
            $worksheet->setCellValueByColumnAndRow(3, $rowIndex, $member->sex);
            $worksheet->setCellValueByColumnAndRow(4, $rowIndex, $member->rank);
            $worksheet->setCellValueByColumnAndRow(5, $rowIndex, $member->birthday);
            $worksheet->setCellValueByColumnAndRow(6, $rowIndex, $member->ic_number);
            $worksheet->setCellValueByColumnAndRow(7, $rowIndex, $member->phone);
            $worksheet->setCellValueByColumnAndRow(8, $rowIndex, $member->tel);
            $worksheet->setCellValueByColumnAndRow(9, $rowIndex, $member->address);
            $worksheet->setCellValueByColumnAndRow(10, $rowIndex, $member->email);
            $worksheet->setCellValueByColumnAndRow(11, $rowIndex, $member->class_type);
            $worksheet->setCellValueByColumnAndRow(12, $rowIndex, $member->class_grade);
            $worksheet->setCellValueByColumnAndRow(13, $rowIndex, $member->class_name);
            $worksheet->setCellValueByColumnAndRow(14, $rowIndex, $member->school_type);
            $worksheet->setCellValueByColumnAndRow(15, $rowIndex, $member->school_name);
            $worksheet->setCellValueByColumnAndRow(16, $rowIndex, $member->school_address);
            $worksheet->setCellValueByColumnAndRow(17, $rowIndex, $member->school_phone);
            $worksheet->setCellValueByColumnAndRow(18, $rowIndex, $member->city_name);
            $worksheet->setCellValueByColumnAndRow(19, $rowIndex, $member->unit_name);
        }
        // close file
        $type = strtoupper($type);
        $objWriter = PHPExcel_IOFactory::createWriter($objExcel, $type);
        // csv settings
        if ($type == "CSV") {
            $objWriter->setEnclosure('');
        }
        $objWriter->save($filePath);
    }
    
}
// End of file