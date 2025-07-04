<?php
defined('BASEPATH') or exit('No direct script access allowed');

class modeldata extends CI_Model
{

    public function get_user($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row();
    }

    public function getBy($table, $where, $dtwhere)
    {
        $this->db->where($where, $dtwhere);
        return $this->db->get($table);
    }
    public function getBy2($table, $where, $dtwhere, $where2, $dtwhere2)
    {
        $this->db->where($where, $dtwhere);
        $this->db->where($where2, $dtwhere2);
        return $this->db->get($table);
    }
    public function getBy3($table, $where, $dtwhere, $where2, $dtwhere2, $where3, $dtwhere3)
    {
        $this->db->where($where, $dtwhere);
        $this->db->where($where2, $dtwhere2);
        $this->db->where($where3, $dtwhere3);
        return $this->db->get($table);
    }
    public function simpan($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    public function edit($table, $data, $where, $dtwhere)
    {
        $this->db->where($where, $dtwhere);
        $this->db->update($table, $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    public function hapus($table, $where, $dtwhere)
    {
        $this->db->where($where, $dtwhere);
        $this->db->delete($table);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
}
