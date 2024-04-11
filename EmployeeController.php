<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;

class EmployeeController extends BaseController
{
    public function index()
    {
        $employeeModel = new EmployeeModel();
        $data['title'] = 'Simple Employee Management';
        $data['employees'] = $employeeModel->findAll();

        return view('employee', $data);
    }

    public function add()
    {
        $employeeModel = new EmployeeModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'gender' => $this->request->getPost('gender'),
            'age' => $this->request->getPost('age'),
            'first_vaccine' => $this->request->getPost('first_vaccine'),
            'second_vaccine' => $this->request->getPost('second_vaccine')
        ];
        $employeeModel->save($data);
        echo '
        <script>
            alert("Employee Data Added");
            window.location="'.base_url('/').'";
        </script>';
    }

    public function edit($id = null) {
        $employeeModel = new EmployeeModel();
        $data['title'] = 'Simple Employee Management';
        $data['employee'] = $employeeModel->find($id);

        return view('employee_edit', $data);
    }

    public function update() {
        $employeeModel = new EmployeeModel();
        $id = $this->request->getPost('id');
        $data = [
            'name' => $this->request->getPost('name'),
            'gender' => $this->request->getPost('gender'),
            'age' => $this->request->getPost('age'),
            'first_vaccine' => $this->request->getPost('first_vaccine'),
            'second_vaccine' => $this->request->getPost('second_vaccine')
        ];
        $employeeModel->update($id, $data);
        echo '
        <script>
            alert("Employee Data Updated");
            window.location="'.base_url('/').'";
        </script>';
    }

    public function delete($id = null) {
        $employeeModel = new EmployeeModel();
        $employeeModel->delete($id);
        echo '
        <script>
            alert("Employee Data Deleted");
            window.location="'.base_url('/').'";
        </script>';
    }

}
