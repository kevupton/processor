<?php
class JobadderPackage extends Package {
    protected $validation = array(
        'method' => 'required',
        'data' => 'required'
    );

    /**
     * Executes the package script with the input data.
     * @return mixed
     * @throws ProcessException if the package
     */
    public function main()
    {
        $this->ci->load->library('jobadder');

        $method = '__' . $this->method;
        if (method_exists($this, $method)) {
            $this->$method();
        }
    }

    public function __SendApplication() {
        $this->ci->load->model('jobadder_model');

        if (isset($this->data['data']->searcher_id)) {
            $sid = $this->data['data']->searcher_id;
            $advertisers = $this->ci->jobadder_model->getAllSearcherJobadderAdvertisers($sid);
            foreach ($advertisers as $advertiser) {
                $this->ci->jobadder->send($sid, $advertiser['advertiser_id']);
            }
        } else {
            throw new ProcessException("Error Invalid arguments");
        }
    }
}