<?php
class SeekPackage extends Package {
    private $applications;

    protected $validation = array(
        'agent_id' => 'required|numeric',
        'advertiser_id' => 'required|numeric'
    );

    /**
     * Executes the package script with the input data.
     * @return mixed
     * @throws ProcessException if the package
     */
    public function main()
    {
        $this->ci->load->library('Seek', array($this->agent_id));
        $this->ci->load->model('admin_model');

        $count = 0;
        $last_id = $this->last_id;
        do {
            $data = array();
            if ($last_id != null) {
                $data['afterid'] = $last_id;
                $this->last_id = $last_id;
            }
            $this->applications = $this->ci->seek->getApplications($data)->JobApplications;
            $this->loadApplicants();
            $last_id = $this->getLastID();
        } while ((++$count) < 4 && ! is_null($last_id));
        $this->goAgain(15);
    }

    /**
     * Gets the last ID of the applications
     *
     * @return int|null the ID of the last application
     */
    private function getLastID() {
        $applications = $this->applications->JobApplicationsList;
        if (count($applications) > 0) {
            $length = count($applications);
            return $applications[$length-1]->ID;
        } else {
            return null;
        }
    }

    /**
     * Loads the applicants into the database.
     */
    private function loadApplicants() {
        $this->ci->load->helper('string');
        foreach ($this->applications->JobApplicationsList as $application) {
            $password = random_string();
            $hash = $this->ci->phpass->hash($password);
            $user = $this->ci->admin_model->get_user_by_email($application->Email);
            if (!empty($user)) continue;

            $this->ci->admin_model->insert_searcher(
                $application->Email,
                $hash,
                $application->FirstName,
                $application->LastName,
                $application->Phone,
                null,
                null
            );
            $user = $this->ci->admin_model->get_user_by_email($application->Email);
            $this->ci->integration_model->set_imported_user($user['user_id'], "Seek", 'advertiser', $this->advertiser_id, (array) $application);

            //Email the user notifying them of their account creation.
        }
    }
}