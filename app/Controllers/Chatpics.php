<?php

namespace App\Controllers;

use CodeIgniter\Files\File;

class Chatpics extends BaseController
{

    use \Myth\Auth\AuthTrait;


    function __construct() 
    {
        $this->config = new \stdClass();
        $this->uri = service('uri');
        $this->auth = service('authentication');
        $this->data = new \stdClass();
        //$this->data->settings = $this->getSystemSettings();
        $this->data->config = new \stdClass();
        $this->data->log = new \stdClass();
        $this->pixabayModel = model('App\Models\ChatpicsPixabayModel');
        $this->tpcModel = model('App\Models\ChatpicsTheparkchatModel');
        $this->keywordModel = model('App\Models\ChatpicsKeywordsModel');
        $this->data->pager = \Config\Services::pager();

    }

    public function view($link) {
        helper('file');
        helper('filesystem');
        // TODO: create helper for mime types 
        // https://github.com/ralouphie/mimey
        $mimes = new \Mimey\MimeTypes; 

        if (preg_match('/(^[a-zA-z]{2})(.*)$/',$link,$matches)) {
            //d($matches);
            switch($matches[1]) {
                case 'pb':
                    if ($img = $this->pixabayModel->select()->where('sid',$matches[2])->first()) {
                        $path = FCPATH.'img/chatpics'.parse_url($img->previewURL)['path'];
                        $data = file_get_contents($path);
                        $parts = explode('.',$path);
                        $ext = array_pop($parts);
                        $mimeType = $mimes->getMimeType($ext);
                        $cacheOptions = [
                            'max-age'   => 86400,
                            's-maxage'  => 604800,
                            'etag'      => md5($data),
                        ];
                        $this->response->setStatusCode(200)->setContentType($mimeType)->setBody($data)->setCache($cacheOptions)->send(); // https://stackoverflow.com/a/64696591/5739340
                        //return $this->response->download($path,null);
                    }
                    break;
                case 'xx':
                    //d($matches);
                    if ($img = $this->tpcModel->select()->where('name',$matches[2])->first()) {
                        $path = FCPATH.'img/chatpics/'.$img->filename;
                        //d($img);
                        
                        $parts = explode('.',$img->filename);
                        $ext = array_pop($parts);
                        $mimeType = $mimes->getMimeType($ext);
                        if ($info = get_file_info($path)) {
                            //d($info);
                            if ($data = file_get_contents($path)) {
                                $cacheOptions = [
                                    'max-age'   => 86400,
                                    's-maxage'  => 604800,
                                    'etag'      => md5($data),
                                ];
                                $this->response->setStatusCode(200)->setContentType($mimeType)->setBody($data)->setCache($cacheOptions)->send();
                            }
                        }
                        //d($path);
                    }
                    //d($this->tpcModel->getLastQuery());
                    break;
            }
            
        }
    }

    public function index()
    {
        $this->data->config->pageTitle = 'Chatpics Browser';
        $this->data->config->searchUrl = '/chatpics/search';
        
        $this->data->keywords = $this->keywordModel->select('keyword')->orderBy('keyword','asc')->find();

        return view('chatpics/index',(array) $this->data);

    }

    public function browser($type,$keyword,$page=1) {

        
        $this->data->config->pageTitle = 'Chatpics';
        $this->data->config->searchUrl = '/chatpics/search';

        //d($type);
        //d($keyword);
        //d($page);

       // d($this->keywordModel);

        $this->data->results = $this->pixabayModel->select()->like('tags',$keyword)->asArray()->paginate(20,'default',$page);
        foreach ($this->data->results as $result) {
            $this->photoDownloader($result['sid'],$result['previewURL']);
        }
        $this->data->total = count($this->pixabayModel->select()->like('tags',$keyword)->asArray()->find());
        $this->data->page = $page;
        
        return view('chatpics/browser',(array) $this->data);


    }

    private function photoDownloader($sid,$url) {

        helper('filesystem');

        if ($parts = parse_url($url)) {
            //d($parts);
            $result = $this->pixabayModel->select()->where('sid',$sid)->first();
            if ($result) {
                //d($result);
                if (!$result->imported) {
                    if ($query = getQuery($url)) {

                        if ($query['code'] == 200) {
                            $img = $query['data'];
                            $pathArray = explode('/',$parts['path']);
                            $filename = array_pop($pathArray);
                            $path = implode('/',$pathArray);
                            //d($img,FCPATH.'img/chatpics'.$path,$filename);
                            $this->createPath(FCPATH.'img/chatpics'.$path);
                            if ( ! write_file(FCPATH.'img/chatpics'.$path.'/'.$filename, $img)) {
                                //d( 'Unable to write the file');
                            } else {
                               // d( 'File written!');
                                $this->pixabayModel->save(['id' => $result->id,'imported'=>1]);
                            }
                            
                        } else {
                            //return redirect()->back()->withInput()->with('error','No search terms entered.');
                        }    
                        
                        
                    }
                }
            } 
            
        } else {
            return false;
        }

    }

/**
 * recursively create a long directory path
 * source: https://stackoverflow.com/a/6205454/5739340
 */
private function createPath($path) {
    if (is_dir($path)) 
        return true;
    $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
    $return = $this->createPath($prev_path);
    return ($return && is_writable($prev_path)) ? mkdir($path) : false;
}

    public function createKeywords()
    {

        $this->data->config->pageTitle = 'Keyword Generator';

        $keywords = array(
            'Angels',
            'Fairies',
            'Animals',
            'Bodyparts',
            'Christmas',
            'Comics',
            'Cartoons',
            'Computers',
            'Dragons',
            'Drugs',
            'Alcohol',
            'Easter',
            'Emoticons',
            'Erotics',
            'Fantasy',
            'Sci-Fi',
            'Female',
            'Fire',
            'Flowers',
            'Plants',
            'Fruits',
            'Food',
            'Gems',
            'Jewelry',
            'Halloween',
            'Hanukkah',
            'Kids',
            'Toys',
            'Knights',
            'Magic',
            'Male',
            'Medieval Weapons',
            'Miscellaneous',
            'Mothers Day',
            'Fathers Day',
            'Music','Mythical Creatures','Myth','Medieval','Nature','Seasons','New Years','Party','Birthday','Places','Religion','Faith','Romance','Science','Space','Signs','Flags','Sports','Games','Teens','Anime','Thanksgiving','Valentines','Vehicles','Weddings','Work','Zodiac'
        );

        //d($keywords);

        foreach ($keywords as $keyword) {
            $this->keywordModel->save(array('keyword' => $keyword));
        }

        d($this->keywordModel->select('keyword')->find());


    }


    public function getPbKeywords() 
    {

        if ($results = $this->pixabayModel->select('tags')->find()) {
            // got pixabay image tags

            if ($results) {
                $_tags = null;
                $tags = null;
                foreach ($results as $result) {
                    //d($result);
                    $_tags = explode(',',$result->tags);
                    //d($_tags);
                    foreach ($_tags as $_tag) {
                        //d($_tag);
                        $tags[] = trim($_tag);
                    }
                }
                
                $tags = array_unique($tags);
            }
            d($tags);
        }



    }


    public function pbImporter($params = NULL,$keyword = NULL,$page = 1)
    {

        $this->data->user = $this->auth->user();
        $this->data->config->pageTitle = 'Pixabay Importer';
        $this->data->config->searchUrl = '/chatpics/pbimporter';

        $this->data->request = $this->request;
        $this->data->results = '';
       // dd($this->request->getMethod());

        if ($this->request->getMethod() != "get") {
            $data = $this->request->getPost();
            if (!$data['query']) {
                return redirect()->back()->withInput()->with('error','No search terms entered.');
            }

            //dd(site_url().'chatpics/pbimporter/keyword/'.$data['query']);
            return redirect()->to(site_url().'chatpics/pbimporter/keyword/'.$data['query']);
            //d($this->request,$data);

           

            return view('chatpics/pbimporter',(array) $this->data);
        } else {

            if ($params) {
                $keywordResults = $this->keywordSearch($keyword,200,$page);
                $this->data->results=$keywordResults['results'];
                d($keywordResults);
            }
            return view('chatpics/pbimporter',(array) $this->data);

          
        }
        
        
        // show the results
        //d($results);

        


    }

    public function search($query = NULL, $page = NULL) {

        $this->data->config->pageTitle = 'Chatpics Search';
        $this->data->config->searchUrl = '/chatpics/search';

        $this->data->request = $this->request;
        $this->data->query = new \stdClass;
        $this->data->page = $page;
        $this->data->segment = 4;

        if ($this->request->getMethod() == "post") {

            if ($this->data->query->keywords = $this->request->getPost('query')) {
                $this->data->query->keywords = str_replace(['?','%'],"",$this->data->query->keywords) ;
                if ($this->data->query->keywords != $this->request->getPost('query') ) {
                    return redirect()->back()->withInput()->with('error','Wildcards are not permitted.');
                }
                if (strlen($this->data->query->keywords) < 3) {
                    return redirect()->back()->withInput()->with('error','Please enter a longer search term.');
                }
                if ($this->data->query->exact = stripslashes($this->request->getPost('exact'))) {
                    //dd($this->data->query);
                    return redirect()->to(site_url().'chatpics/browser/keyword/'.$this->data->query->keywords);
                } else {

                    return redirect()->to(site_url().'chatpics/search/'.stripslashes($this->data->query->keywords).'/1');

                }
            } else {
                return redirect()->back()->withInput()->with('error','No search terms entered.');
            }
        } else {

            // get

            $this->data->query->keywords = $query;
            
            $search_text=ltrim($this->data->query->keywords);
            $search_text=rtrim($search_text);

            //d($search_text);

            $kt=explode(" ",$search_text);//Breaking the string to array of words

           //d($kt);

            // Now let us generate the sql 
            $search = $this->pixabayModel->select(); // TODO: This only searches existing images in database. This does not allow addition of new ones because the keyword method is responsible for that.
            if (count($kt) > 1) {
                foreach ($kt as $key => $val) {
                    if (($val) && (strlen($val) > 0)) {
                        $search->orLike('tags',$val);
                    }
                }
            } else {
                $search->like('tags',$kt[0]);
            }


            $search->asArray();
            
            //d($search->getCompiledSelect(),$search);

            if ($this->data->page) {

                $this->data->results = $search->paginate(20,'default',$this->data->page);
                //d($search->getLastQuery());
                $this->data->pager = $search->pager;
                $this->data->pager->setSegment(4,'default');
                //d($search->pager);
            } else {

                $this->data->results = $search->find();
                $this->data->total = count($this->data->results);
            }

            foreach ($this->data->results as $result) {
                $this->photoDownloader($result['sid'],$result['previewURL']);
            }
          
            return view('chatpics/browser',(array) $this->data);


            //dd($this->data->results, $this->data->total,$this->data->page);
        }

    }

    public function keywordSearch($data,$per_page = 20,$page = 1) {
        //d($data);
        $result = $this->pixabayQuery($data, $per_page, $page);

        return $result;

    }
    
    private function pixabayQuery($query,$per_page = 20, $page = 1) {

        $per_page = 200;
        //$page = $page;
        $apiResult = Pixabay(['q'=>$query,'per_page'=>$per_page,'page'=>$page]);
        $result = null;
        if ($apiResult) {
            $pages = ceil($apiResult['totalHits'] / $per_page);
            foreach ($apiResult['hits'] as $hit) {
                if (($hit['previewWidth'] > 150) || ($hit['previewHeight'] > 100)) {
                    continue;
                }
                $hit['sid'] = $hit['id'];
                unset($hit['id']);
                $result[] = $hit;
                $this->pixabayModel->save($hit);
            }


            for ($i=2;$i<=$pages;$i++) {
                //d($i);
                $_apiResult = Pixabay(['q'=>$query,'per_page'=>$per_page,'page'=>$i]);
                if ($_apiResult) {
                    foreach ($_apiResult['hits'] as $hit) {
                        if (($hit['previewWidth'] > 150) || ($hit['previewHeight'] > 100)) {
                            continue;
                        }
                        $hit['sid'] = $hit['id'];
                        unset($hit['id']);
                        $result[] = $hit;
                        $this->pixabayModel->save($hit);
                    }
                }
            }            

            return array('pages'=>$pages,'per_page'=>$per_page,'page'=>$page,'results'=>$result);
        }



    }

}
