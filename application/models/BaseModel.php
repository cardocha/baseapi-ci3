<?php

abstract class BaseModel extends CI_Model
{
    abstract function get_table_name();

    public function persist($data)
    {
        $cleaned_data = $this->sanitize_fields($data, $this->get_table_name());

        if (isset($cleaned_data['id']) && intval($cleaned_data['id']) > 0)
            return $this->update($cleaned_data);

        unset($cleaned_data['id']);

        $this->db->set($cleaned_data);
        $this->db->insert($this->get_table_name());
        return $this->db->insert_id();
    }

    public function update($data)
    {
        $cleaned_data = $this->sanitize_fields($data, $this->get_table_name());
        $this->db->where('id', $cleaned_data['id']);
        return $this->db->update($this->get_table_name(), $cleaned_data);
    }

    public function sanitize_fields($data, $table_name)
    {
        $table_fields = $this->db->list_fields($table_name);
        $posted_fields = array_keys($data);
        foreach ($posted_fields as $posted_field) {
            if (!in_array($posted_field, $table_fields))
                unset($data[$posted_field]);
        }
        return $data;
    }

    function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->get_table_name());
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->get_table_name());
        $query = $this->db->get();
        return $query->result();
    }
}