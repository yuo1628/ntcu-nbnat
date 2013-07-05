<?php
require_once APPPATH . 'libraries/files/fileerror.php';

class NewsController extends MY_Controller {
	// 公佈欄功能的基本URL
	private $PREFIX_URL = './index.php/news/';
	// 下載檔案的連結
	private $DOWNLOAD_URL = './index.php/news/download';
	// 每頁顯示多少筆數
	private $per_page = 9;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('news/category_model');
		$this->load->model('files/file_model');
		$this->load->library('news/news_library');
		$this->load->library('files/filemanagement');
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->load->database();
	}
	
	public function index()
	{
		//$this -> layout -> view('view/news/index', $this->_mainmenu());
		$this->manage();
	}
	
	public function read($id=NULL)
	{	
		if (is_null($id)) {
			show_404();
		}
		$data = $this->_mainmenu();
		$news = $this->news_library->get_news_by_id($id);
		if (is_null($news)) {
			show_404();
		}
		$data['news'] = $news;
		$data['download_url'] = $this->DOWNLOAD_URL;
		$this -> layout -> view('view/news/read', $data);
	}
	
	public function download($id = NULL)
	{
		if (is_null($id)) {
			show_404();
		}
		$fileArray = $this->filemanagement->get_file($id);
		if (is_null($fileArray)) {
			show_404();
		}
		$this->output->set_content_type('application/octet-stream');
		$this->output->set_header('Content-Disposition: attachment; filename="' . $fileArray[0] . '"');
		$this->output->set_output(file_get_contents($fileArray[1]));
	}
	
	/**
	 * 顯示並管理所有公告
	 *
	 * @param string $order_by 可傳入'publish_time'或'edit_time'
	 * @param string $order 可傳入'desc'或'asc'
	 * @param int $page
	 */
	public function manage($order_by='publish_time', $order='desc', $page=0, $per_page=9)
	{
		//$order_by = $this->input->get('order_by');
		$order_by = in_array($order_by, array('publish_time', 'edit_time', 'category')) ? $order_by : 'publish_time';
		//$order = $this->input->get('order');
		$order = in_array($order, array('desc', 'asc')) ? $order : 'desc';
		$news_count = $this->_get_news_count();
		$page = $page >=0 && $page < $news_count ? $page : 0;
		$per_page = $per_page > 0 ? $per_page : $this->_get_per_page();
		
		$data = $this->_mainmenu();
		$data['read_url'] = $this->PREFIX_URL . 'read';
		$news_list = $this->news_library->get_news(9, $page, $order, $order_by == 'category' ? 'category_id' : $order_by);
		$data['news_list'] = $news_list;
		$this->pagination->initialize(array('base_url' => $this->PREFIX_URL . "manage/{$order_by}/{$order}",
											'total_rows' => $this->_get_news_count(),
											'per_page' => $per_page,
											'uri_segment' => 5));
		$data['pagination'] = $this->pagination;
		$data['manage_url'] = $this->PREFIX_URL . 'manage';
		$data['order'] = $order;
		$data['order_by'] = $order_by;
		$data['redirect_url'] = 'news/manage';
		$this-> layout -> view('view/news/manage', $data);
	}
	
	public function add()
	{
		// 初始化資料
		$data = $this->_mainmenu();
		$data['title'] = '新增公告';
		$data['post_url'] = $this->PREFIX_URL . 'add';
		$data['download_url'] = $this->PREFIX_URL . 'download';
		$data['errors'] = array();
		$categories = $this->category_model->get();
		$data['category_list'] = $categories;
		$data['news'] = $this->news_library->create();
		//print_r($this->input->post());
		//print_r($_FILES);
		
		$postData = $this->input->post();
		// 處理使用者傳入資料
		if ($postData !== FALSE) {
			// 取得POST資料
			$title = $this->input->post('title');
			$content = $this->input->post('content');
			$categoryId = $this->input->post('category');
			$data['news']->title = $title;
			$data['news']->content = $content;
			$data['news']->set_category_by_id($categoryId);
			$data['news']->set_author_by_id($this->_getCurrentAuthorId());
			// 驗證
			$hasError = FALSE;
			$validate_errors = $this->_validate_news($data['news']);
			if ($validate_errors) {
				$hasError = TRUE;
				foreach ($validate_errors as $validate_error) {
					$data['errors'][] = $validate_error;
				}
			}
			// 處理上傳檔案
			if (!$hasError) {
				$errors = $this->_uploadFiles($data['news'], NULL, $_FILES['files']);
				if ($errors) {
					$hasError = TRUE;
					// array(errorFileName, array(errors))
					foreach ($errors[1] as $error) {
						$data['errors'][] = "\"{$errors[0]}\"" . ' ' . $error->get_error_message();
					}
				}
			}
			// 儲存公告
			if (!$hasError && $data['news']->save()) {
				redirect('./news/read/' . $data['news']->id, 'Location');
			}
		}
		$this-> layout -> view('view/news/edit', $data);
	}
	
	public function edit($id=NULL)
	{
		if (is_null($id)) {
			show_404();
		}
		// 觸發刪除檔案動作
		if ($this->input->post('delete_edit_file') !== FALSE) {
			$this->_delete_edit_file();
		}
		// 初始化資料
		$news = $this->news_library->get_news_by_id($id);
		if (is_null($news)) {
			show_404();
		}
		$data = $this->_mainmenu();
		$data['title'] = '編輯公告';
		$data['post_url'] = $this->PREFIX_URL . 'edit' . "/{$news->id}";
		$data['download_url'] = $this->DOWNLOAD_URL;
		$data['errors'] = array();
		$categories = $this->category_model->get();
		$data['category_list'] = $categories;
		$data['news'] = $news;
		// 有POST資料，執行更新操作
		if ($this->input->post('edit') !== FALSE) {
			$hasError = FALSE;
			$news->title = $this->input->post('title');
			$news->content = $this->input->post('content');
			if ($news->set_category_by_id($this->input->post('category')) === FALSE) {
				$hasError = TRUE;
				$date['errors'][] = '未填入分類';
			}
			$news->edit_time = NULL;
			$validateErrors = $this->_validate_news($news);
			if ($validateErrors) {
				$hasError = TRUE;
				foreach ($validateErrors as $validateError) {
					$data['errors'][] = $validateError;
				}
			}
			if (!$hasError) {
				$fileErrors = $this->_uploadFiles($news, NULL, $_FILES['files']);
				if ($fileErrors) {
					$hasError = TRUE;
					$fileErrorMessages = $fileErrors[1];
					foreach ($fileErrorMessages as $fileErrorMessage) {
						$data['errors'][] = "\"{$fileErrors[0]}\"" . " {$fileErrorMessage}";
					}
				}
			}
			if (!$hasError && $news->save()) {
				redirect("news/read/{$news->id}");
			}
		}
		$this-> layout -> view('view/news/edit', $data);
		
	}
	
	/**
	 * 刪除指定公告與其附件
	 *
	 * 預期從POST接受id和redirect_url資料
	 */
	public function delete()
	{
		$id = $this->input->post('id');
		if ($id === FALSE) {
			show_404();
		}
		$news = $this->news_library->get_news_by_id($id);
		if (is_null($news)) {
			show_404();
		}
		$news->delete();
		foreach ($news->files as $file) {
			$this->filemanagement->delete_file($file->id);
		}
		$redirectUrl = $this->input->post('redirect_url');
		redirect($redirectUrl ? $redirectUrl : './news/manage', 'Location');
	}
	
	private function _delete_edit_file()
	{
		$news_id = $this->input->post('news_id');
		if ($news_id === FALSE) {
			show_404();
		}
		$this->delete_file();
	}
	
	/**
	 * 刪除檔案
	 *
	 * 刪除失敗會顯示404找不到網頁
	 *
	 * 此方法會去讀去post資料中名稱為file_id的資料
	 */
	public function delete_file()
	{
		$file_id = $this->input->post('file_id');
		if ($file_id === FALSE) {
			show_404();
		}
		// ON DELETE CASCADE
		if ($this->filemanagement->delete_file($file_id) === FALSE) {
			show_404();
		}
	}
	
	private function _mainmenu()
	{
		$itemList = array("itemList" => array(
		 array("back","./index.php/home", "返回主選單"),
		 array("news", "./index.php/news/manage", "公佈欄管理"), 
		 array("create", "./index.php/news/add", "建立公告"),
		 array("logout", "./", "登出帳號")
		), 'state' => $this->_userMeta());
		return $itemList;
	}
	
	
	//// 未實作完成
	/**
	 * 新增上傳的檔案至指定的公告
	 *
	 * 此方法會自動將上傳的檔案儲存，但不會自動儲存公告類別實體
	 *
	 * @param News $news
	 * @param Filechecker $filechecker
	 * @parm array $files
	 * @return array 格式為array(errorFileName, array(FileError, ...))
	 */
	private function _uploadFiles($news, $filechecker, $files)
	{
		foreach ($files['error'] as $key => $errorCode) {
			// No upload file
			if ($errorCode == 4) {
				return array();
			} else if ($errorCode != 0) {
				return array($files['name'][$key], array(new Fileerror($errorCode)));
			}
		}
		/*
		foreach ($files['tmp_name'] as $key => $path) {
			$result = $filechecker->check_file($path);
			// 有錯誤
			if ($result) {
				return $result;
			}
		}*/
		
		// 驗證完成，將檔案新增至資料庫和檔案系統
		foreach ($files['tmp_name'] as $key => $path) {
			$id = $this->filemanagement->save_file($files['name'][$key], $path);
			$file_array = $this->file_model->where('id', $id)->get();
			$file = $file_array[0];
			$news->append_files($file);
		}
		return array();
	}
	
	//// mock-up
	/**
	 * 取得目前作者的編號
	 *
	 * @return int
	 */
	private function _getCurrentAuthorId()
	{
		//$loginUser = $this->member_system->authentication->getLoginUser();
		//print($loginUser);
		/*
		if ($this->member_system->authentication->isLogin()) {
			print "Login";
		} else {
			print "UnLogin";
		}*/
		return $this->session->userdata("user")[0]->id;
		return 1;
	}
	
	private function _userMeta() {
		return $this -> load -> view('view/userMeta',"",TRUE);
	}
	
	/**
	 * 驗證公告資料的正確性
	 *
	 * @param News $news
	 * @return array 回傳包含錯誤訊息的陣列
	 */
	private function _validate_news($news)
	{
		$errors = array();
		if (!$news->title) {
			$errors[] = "未填入標題";
		}
		if (!$news->content) {
			$errors[] = "未填入內文";
		}
		if (!$news->author) {
			$errors[] = "未填入作者";
		}
		if (!$news->category) {
			$errors[] = "未填入分類";
		}
		return $errors;
	}
	
	// Temporary Fix
	private function _get_news_count()
	{
		return $this->db->count_all('news');
	}
	
	/**
	 * 設定每頁顯示多少筆數的公告
	 *
	 * @access private
	 * @param int $per_page
	 */
	private function _set_per_page($per_page)
	{
		$this->pagination->per_page = $per_page;
		$this->per_page = $per_page;
	}
	
	/**
	 * 取得每頁顯示多少筆數的公告
	 *
	 * @access private
	 * @return int
	 */
	private function _get_per_page()
	{
		return $this->per_page;
	}
}
// End of file