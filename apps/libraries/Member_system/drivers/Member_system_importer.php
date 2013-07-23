<?php
require_once './phpexcel/PHPExcel/IOFactory.php';

/**
 * Member_system_importer
 *
 * @author Yuo <pors37@gmail.com>
 */
class Member_system_importer extends CI_Driver {
    
    private $CI;
    
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('member_model');
    }
    
    /**
     * 將指定的Excel檔案中的會員資料新增至資料庫
     *
     * @access public
     * @param string $fileName
     * @param boolean $hasTitle
     */
    public function importMembersFromExcel($fileName, $hasTitle)
    {
        $members = $this->readMembersFromExcel($fileName, $hasTitle);
        $this->saveMembers($members);
    }
    
    /**
     * 從Excel檔讀取會員資料
     *
     * @access public
     * @param string $fileName
     * @param boolean $hasTitle
     * @return array 回傳包含Member實體的陣列
     */
    public function readMembersFromExcel($fileName, $hasTitle)
    {
        // 讀取檔案
        $objPHPExcel = PHPExcel_IOFactory::load($fileName);
        // 分析檔案列（跳過第一行）
        $members = array();
        $rows = $objPHPExcel->getActiveSheet()->getRowIterator();
        if ($hasTitle) {
            $rows->next();
        }
        while ($rows->valid()) {
            $members[] = $this->readMemberFromRow($rows->current());
            $rows->next();
        }
        // 將分析結果集合並回傳
        return $members;
    }
    
    /**
     * 從一列資料行中讀取會員資料
     *
     * @access private
     * @param PHPExcel_Row $row
     * @return Member
     */
    private function readMemberFromRow($row)
    {
        // 讀取Columns
        // 將Column的資料填入新的Member實體中
        $newMember = $this->get_empty_member_instance();
        $cells = $row->getCellIterator();
        $cells->setIterateOnlyExistingCells(False);
        $readCell = function ($cells) {
            $value = $cells->current()->getValue();
            $cells->next();
            return $value;
        };
        $newMember->username = $readCell($cells);
        $newMember->password = $readCell($cells);
        $newMember->name = $readCell($cells);
        $newMember->sex = $readCell($cells);
        $newMember->rank = $readCell($cells);
        $newMember->birthday = $readCell($cells);
        $newMember->ic_number = $readCell($cells);
        $newMember->phone = $readCell($cells);
        $newMember->tel = $readCell($cells);
        $newMember->address = $readCell($cells);
        $newMember->email = $readCell($cells);
        $newMember->class_type = $readCell($cells);
        $newMember->class_grade = $readCell($cells);
        $newMember->class_name = $readCell($cells);
        $newMember->school_type = $readCell($cells);
        $newMember->school_name = $readCell($cells);
        $newMember->school_address = $readCell($cells);
        $newMember->school_phone = $readCell($cells);
        $newMember->city_name = $readCell($cells);
        $newMember->unit_name = $readCell($cells);
        $newMember->city_id = $this->findExistingCityId($newMember->city_name);
        $newMember->school_id = $this->findExistingSchoolId($newMember->school_type,
                                                            $newMember->school_name,
                                                            $newMember->school_address,
                                                            $newMember->school_phone,
                                                            $newMember->city_id);
        $newMember->class_id = $this->findExistingClassId($newMember->class_type,
                                                          $newMember->class_grade,
                                                          $newMember->class_name,
                                                          $newMember->school_id);
        $newMember->unit_id = $this->findExistingUnitId($newMember->unit_name);
        return $newMember;
    }
    
    /**
     * 尋找指定城市的資料庫編號
     *
     * @access private
     * @param string $cityName
     * @return int|NULL 找不到符合條件的城市則會回傳NULL
     */
    private function findExistingCityId($cityName)
    {
        $cities = $this->CI->member_model->get_city(array($this->CI->member_model->CITY_NAME => $cityName));
        if ($cities) {
            $city = $cities[0];
            return $city->id;
        }
        return NULL;
    }
    
    /**
     * 尋找指定學校的資料庫編號
     *
     * @access private
     * @param string $schoolType
     * @param string $schoolName
     * @param string $schoolAddress
     * @param string $schoolPhone
     * @param string $schoolCityId
     * @return int|NULL 找不到符合條件的學校則會回傳NULL
     */
    private function findExistingSchoolId($schoolType, $schoolName, $schoolAddress, $schoolPhone, $schoolCityId)
    {
        $schools = $this->CI->member_model->get_school(array($this->CI->member_model->SCHOOL_TYPE => $schoolType,
                                                             $this->CI->member_model->SCHOOL_NAME => $schoolName,
                                                             $this->CI->member_model->SCHOOL_ADDRESS => $schoolAddress,
                                                             $this->CI->member_model->SCHOOL_PHONE => $schoolPhone,
                                                             $this->CI->member_model->SCHOOL_CITY_ID => $schoolCityId));
        if ($schools) {
            $school = $schools[0];
            return $school->id;
        }
        return NULL;
    }
    
    /**
     * 尋找指定班級的資料庫編號
     *
     * @access private
     * @param string $classType
     * @param string $classGrade
     * @param string $className
     * @param string $classSchoolId
     * @return int|NULL 找不到符合條件的班級則會回傳NULL
     */
    private function findExistingClassId($classType, $classGrade, $className, $classSchoolId)
    {
        $classes = $this->CI->member_model->get_class(array($this->CI->member_model->CLASS_TYPE => $classType,
                                                            $this->CI->member_model->CLASS_GRADE => $classGrade,
                                                            $this->CI->member_model->CLASS_NAME => $className,
                                                            $this->CI->member_model->CLASS_SCHOOL_ID => $classSchoolId));
        if ($classes) {
            $class = $classes[0];
            return $class->id;
        }
        return NULL;
    }
    
    /**
     * 尋找指定服務單位的資料庫編號
     *
     * @access private
     * @param string $unitName 服務單位名稱
     * @retrun int|NULL 找不到符合條件的服務單位則會回傳NULL
     */
    private function findExistingUnitId($unitName)
    {
        $units = $this->CI->member_model->get_unit(array($this->CI->member_model->UNIT_NAME => $unitName));
        if ($units) {
            $unit = $units[0];
            return $unit->id;
        }
        return NULL;
    }
    
    /**
     * 將指定的會員新增至資料庫
     *
     * 此方法會將為新增至資料庫的服務單位、班級、學校、城市等資料自動
     * 新增至資料庫。
     *
     * @access private
     * @param array $members
     */
    private function saveMembers($members)
    {
        foreach($members as $member)
        {
            $member->city_id = $this->findExistingCityId($member->city_name);
            $member->school_id = $this->findExistingSchoolId($member->school_type,
                                                             $member->school_name,
                                                             $member->school_address,
                                                             $member->school_phone,
                                                             $member->city_id);
            $member->class_id = $this->findExistingClassId($member->class_type,
                                                           $member->class_grade,
                                                           $member->class_name,
                                                           $member->school_id);
            $member->unit_id = $this->findExistingUnitId($member->unit_name);
            if (is_null($member->unit_id)) {
                $member->unit_id = $this->CI->member_model->insert_unit(array($this->CI->member_model->UNIT_NAME => $member->unit_name));
            }
            if (is_null($member->city_id)) {
                $member->city_id = $this->CI->member_model->insert_city(array($this->CI->member_model->CITY_NAME => $member->city_name));
            }
            if (is_null($member->school_id)) {
                $member->school_id = $this->CI->member_model->insert_school(array($this->CI->member_model->SCHOOL_TYPE => $member->school_type,
                                                                                  $this->CI->member_model->SCHOOL_NAME => $member->school_name,
                                                                                  $this->CI->member_model->SCHOOL_ADDRESS => $member->school_address,
                                                                                  $this->CI->member_model->SCHOOL_PHONE => $member->school_phone,
                                                                                  $this->CI->member_model->SCHOOL_CITY_ID => $member->city_id));
            }
            if (is_null($member->class_id)) {
                $member->class_id = $this->CI->member_model->insert_class(array($this->CI->member_model->CLASS_TYPE => $member->class_type,
                                                                                $this->CI->member_model->CLASS_GRADE => $member->class_grade,
                                                                                $this->CI->member_model->CLASS_NAME => $member->class_name,
                                                                                $this->CI->member_model->CLASS_SCHOOL_ID => $member->school_id));
            }
            $this->CI->member_model->insert(array($this->CI->member_model->USERNAME => $member->username,
                                                  $this->CI->member_model->PASSWORD => $member->password,
                                                  $this->CI->member_model->NAME => $member->name,
                                                  $this->CI->member_model->SEX => $member->sex,
                                                  $this->CI->member_model->RANK => $member->rank,
                                                  $this->CI->member_model->BIRTHDAY => $member->birthday,
                                                  $this->CI->member_model->IC_NUMBER => $member->ic_number,
                                                  $this->CI->member_model->PHONE => $member->phone,
                                                  $this->CI->member_model->TEL => $member->tel,
                                                  $this->CI->member_model->ADDRESS => $member->address,
                                                  $this->CI->member_model->EMAIL => $member->email,
                                                  $this->CI->member_model->CREATED_TIME => $member->created_time,
                                                  $this->CI->member_model->PASSWORD_EDITED_TIME => $member->password_edited_time,
                                                  $this->CI->member_model->UNIT_ID => $member->unit_id,
                                                  $this->CI->member_model->CLASS_ID => $member->class_id));
        }
    }
}
// End of file