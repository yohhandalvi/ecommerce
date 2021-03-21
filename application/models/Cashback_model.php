<?php

class Cashback_model extends CI_Model {
 
    public function add($data)
    {
        $cashback = [
            'name' => $data['name'],
            'description' => trim($data['description']),
            'limit_to' => $data['limit_to'],
            'limit_to_customer_group_id' => (isset($data['limit_to_customer_group_id']) && $data['limit_to'] == 'user_group') ? @$data['limit_to_customer_group_id'] : 0,
            'valid_from_date' => $data['valid_from_date'],
            'valid_to_date' => $data['valid_to_date'],
            'available' => @$data['available'],
            'available_for_single_user' => @$data['available_for_single_user'],
            'type' => $data['type'],
            'value' => @$data['value'], 
            'max_value' => @$data['max_value'],
            'apply_cashback_to' => @$data['apply_cashback_to'],
            'max_value_on_total_order' => isset($data['max_value_on_total_order']) ? @$data['max_value_on_total_order'] : 0,
            'inactive' => @$data['inactive']
        ];

        $this->db->insert('cashbacks', $cashback);
        $cashback_id = $this->db->insert_id();

        if(isset($data['limit_to']) && $data['limit_to'] == 'custom' && !empty($data['limit_to_customers'])) {
            foreach ($data['limit_to_customers'] as $key => $limit_to_customer) {
                $this->db->insert('cashback_for_customers', array(
                    'cashback_id' => $cashback_id,
                    'customer_id' => $limit_to_customer
                ));
            }
        }

        if(isset($data['apply_cashback_to']) && $data['apply_cashback_to'] == 'custom' && !empty($data['apply_to_products'])) {
            foreach ($data['apply_to_products'] as $key => $apply_to_product) {
                $this->db->insert('cashback_for_products', array(
                    'cashback_id' => $cashback_id,
                    'product_id' => $apply_to_product
                ));
            }
        }

        return $cashback_id;
    }

    public function update($id, $data)
    {
        $cashback = [
            'name' => $data['name'],
            'description' => trim($data['description']),
            'limit_to' => $data['limit_to'],
            'limit_to_customer_group_id' => (isset($data['limit_to_customer_group_id']) && $data['limit_to'] == 'user_group') ? @$data['limit_to_customer_group_id'] : 0,
            'valid_from_date' => $data['valid_from_date'],
            'valid_to_date' => $data['valid_to_date'],
            'available' => @$data['available'],
            'available_for_single_user' => @$data['available_for_single_user'],
            'type' => $data['type'],
            'value' => @$data['value'],
            'max_value' => @$data['max_value'],
            'apply_cashback_to' => @$data['apply_cashback_to'],
            'max_value_on_total_order' => isset($data['max_value_on_total_order']) ? @$data['max_value_on_total_order'] : 0,
            'inactive' => @$data['inactive']
        ];

        $this->db->where('id', $id);
        $result = $this->db->update('cashbacks', $cashback);

        if(isset($data['limit_to']) && $data['limit_to'] == 'custom' && !empty($data['limit_to_customers'])) {
            $this->db->delete('cashback_for_customers', array('cashback_id' => $id));
            foreach ($data['limit_to_customers'] as $key => $limit_to_customer) {
                $this->db->insert('cashback_for_customers', array(
                    'cashback_id' => $id,
                    'customer_id' => $limit_to_customer
                ));
            }
        }

        if(isset($data['apply_cashback_to']) && $data['apply_cashback_to'] == 'custom' && !empty($data['apply_to_products'])) {
            $this->db->delete('cashback_for_products', array('cashback_id' => $id));
            foreach ($data['apply_to_products'] as $key => $apply_to_product) {
                $this->db->insert('cashback_for_products', array(
                    'cashback_id' => $id,
                    'product_id' => $apply_to_product
                ));
            }
        }

        return $result;
    }

    public function update_keys($id, $data)
    {
        return $this->db->update('cashbacks', $data, array('id' => $id));
    }

    public function get_all_cashbacks($limit = 0, $offset = 0, $params = null)
    {
        if($limit)
            $this->db->limit($limit, $offset);

        if(!empty($params['exclude_ids']))
            $this->db->where_not_in('c.id', $params['exclude_ids']);

        if(!empty($params['search'])) {
            $this->db->group_start();
            $this->db->like('c.id', $params['search'], 'both');
            $this->db->or_like('c.name', $params['search'], 'both');
            $this->db->group_end();
        }

        if(!empty($params['select']))
            $this->db->select($params['select']);
        else
            $this->db->select('c.*');

        $this->db->from('cashbacks c');


        $this->db->where('c.deleted', 0);

        if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'c.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'c.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
            $this->db->order_by('c.id', 'ASC');
        }
        return $this->db->get()->result_array();
    }

    public function get_cashback_by_id($id)
    {
        $this->db->select('c.*, GROUP_CONCAT(cfc.customer_id) as limit_to_customers, GROUP_CONCAT(cfr.product_id) as apply_to_products');
        $this->db->from('cashbacks c');
        $this->db->join('cashback_for_customers cfc', 'cfc.cashback_id = c.id', 'left');
        $this->db->join('cashback_for_products cfr', 'cfr.cashback_id = c.id', 'left');
        $this->db->where('c.deleted', 0);
        $this->db->where('c.id', $id);
        return $this->db->get()->row_array();
    }

    public function count_all_cashbacks($params = null)
    {
        if(!empty($params['exclude_ids']))
            $this->db->where_not_in('c.id', $params['exclude_ids']);

        if(isset($params['inactive']) && is_numeric($params['inactive']))
            $this->db->where('c.inactive', $params['inactive']);

        if(!empty($params['search'])) {
            $this->db->group_start();
            $this->db->like('c.id', $params['search'], 'both');
            $this->db->or_like('c.name', $params['search'], 'both');
            $this->db->group_end();
        }

        $this->db->where('c.deleted', 0);
        return $this->db->count_all_results('cashbacks c');
    }

    public function get_used_cashbacks($cashback_id)
    {
        $this->db->where('cashback_id', $cashback_id);
        return $this->db->count_all_results('order_cashbacks');
    }

    public function get_customer_used_cashbacks($customer_id, $cashback_id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('cashback_id', $cashback_id);
        return $this->db->count_all_results('order_cashbacks');
    }

    public function get_valid_cashback($product_id)
    {
        $cashbacks = $this->get_active_cashbacks();

        if(!empty($cashbacks))
        {
            foreach ($cashbacks as $key => $cashback)
            {
                $valid = $this->validate_cashback($product_id, $cashback);

                if($valid)
                {
                    return $valid;
                }
            }
        }

        return NULL;
    }

    public function get_active_dated_cashback($cashback, $id = 0)
    {
        $return  = TRUE;

        if($cashback['valid_from_date'] !== "" && $cashback['valid_to_date'] !== "")
        {
            $where = "";

            if($id > 0)
                $where = " AND id <> ".$id;

            $sql = "SELECT * FROM cashbacks c WHERE (unix_timestamp(c.valid_from_date) IS NULL || (unix_timestamp(c.valid_from_date) IS NOT NULL) AND c.valid_from_date <= ?) AND (unix_timestamp(c.valid_to_date) IS NULL || (unix_timestamp(c.valid_from_date) IS NOT NULL) AND c.valid_to_date >= ?)  AND c.deleted = 0 $where";

            $active_cashback = $this->db->query($sql, [$cashback['valid_to_date'], $cashback['valid_from_date']])->row_array();

            if(empty($active_cashback))
            {
                $return  = FALSE;
            }
            else
            {
                $products = [];
                $customers = [];

                $cashback_for_products = $this->db->get_where('cashback_for_products', ['cashback_id' => $active_cashback['id']])->result_array();

                if(!empty($cashback_for_products))
                {
                    foreach ($cashback_for_products as $cashback_for_product)
                    {
                        $products[] = $cashback_for_product['product_id'];
                    }
                }

                $cashback_for_customers = $this->db->get_where('cashback_for_customers', ['cashback_id' => $active_cashback['id']])->result_array();

                if(!empty($cashback_for_customers))
                {
                    foreach ($cashback_for_customers as $cashback_for_customer)
                    {
                        $customers[] = $cashback_for_customer['customer_id'];
                    }
                }

                $active_cashback['products'] = $products;
                $active_cashback['customers'] = $customers;

                if($active_cashback['apply_cashback_to'] == "all" || $cashback['apply_cashback_to'] == "all" || ($active_cashback['limit_to'] == "user_group" && $active_cashback['limit_to_customer_group_id'] == $cashback['limit_to_customer_group_id']))
                {
                    $return = TRUE;
                }
                else
                {
                    if($active_cashback['apply_cashback_to'] == "custom" && $cashback['apply_cashback_to'] == "custom")
                    {
                        if(empty(array_intersect($active_cashback['products'], $cashback['apply_to_products'])))
                        {
                            $return = FALSE;
                        }
                    }
                }
            }
        }

        return $return;
    }

    public function validate_cashback($product_id, $cashback)
    {
        $valid = false;
        $valid = $this->check_if_valid_date($cashback);
        $valid = ($valid && $this->check_if_valid_limitation($cashback));
        $valid = ($valid && $this->check_if_valid_availability($cashback));
        $valid = ($valid && $this->check_if_valid_product($product_id, $cashback));
        return ($valid) ? $cashback : NULL;
    }

    private function get_active_cashbacks()
    {
        $sql = "SELECT * FROM cashbacks c WHERE (unix_timestamp(c.valid_from_date) IS NULL || (unix_timestamp(c.valid_from_date) IS NOT NULL) AND c.valid_from_date <= NOW()) AND (unix_timestamp(c.valid_to_date) IS NULL || (unix_timestamp(c.valid_from_date) IS NOT NULL) AND c.valid_to_date >= NOW()) AND c.deleted = 0";

        $cashbacks = $this->db->query($sql)->result_array();

        if(!empty($cashbacks))
        {
            $products = [];
            $customers = [];

            foreach ($cashbacks as $key => $cashback)
            {
                $cashback_for_products = $this->db->get_where('cashback_for_products', ['cashback_id' => $cashback['id']])->result_array();

                if(!empty($cashback_for_products))
                {
                    foreach ($cashback_for_products as $cashback_for_product)
                    {
                        $products[] = $cashback_for_product['product_id'];
                    }
                }

                $cashback_for_customers = $this->db->get_where('cashback_for_customers', ['cashback_id' => $cashback['id']])->result_array();

                if(!empty($cashback_for_customers))
                {
                    foreach ($cashback_for_customers as $cashback_for_customer)
                    {
                        $customers[] = $cashback_for_customer['customer_id'];
                    }
                }

                $cashbacks[$key]['products'] = $products;
                $cashbacks[$key]['customers'] = $customers;
            }
        }

        return $cashbacks;
    }

    private function check_if_valid_date($cashback)
    {
        $time = strtotime(date('Y-m-d'));

        if(((strtotime($cashback['valid_from_date']) <= 0) || (strtotime($cashback['valid_from_date']) > 0 && $time >= strtotime($cashback['valid_from_date']))) && ((strtotime($cashback['valid_to_date']) <= 0) || (strtotime($cashback['valid_to_date']) > 0 && $time <= strtotime($cashback['valid_to_date'])))) {
            return true;
        }

        return false;
    } 

    private function check_if_valid_limitation($cashback)
    {
        $return = false;

        if($cashback['limit_to'] == "all") {
            $return = true;
        } else {
            if($this->customer['id']) {
                $this->load->model('Customer_model');
                $customer = $this->Customer_model->get_customer_by_id($this->customer['id']);
                if($cashback['limit_to'] == "user_group" && $customer['customer_group_id'] >= $cashback['limit_to_customer_group_id']) {
                    $return = true;
                } else if($cashback['limit_to'] == "custom" && in_array($customer['id'], $cashback['customers'])) {
                    $return = true;
                }
            } else {
                $return = true;
            }
        }

        return $return;
    }

    private function check_if_valid_availability($cashback)
    {
        $return = true;

        $used_cashbacks = $this->get_used_cashbacks($cashback['id']);

        if($cashback['available'] > 0) {
            $used_cashbacks = $this->get_used_cashbacks($cashback['id']);
            if($used_cashbacks >= $cashback['available']) {
                $return = false;
            }
        }

        if($cashback['available_for_single_user'] > 0 && $this->customer['id']) {
            $customer_used_cashbacks = $this->get_customer_used_cashbacks($this->customer['id'], $cashback['id']);
            if($customer_used_cashbacks >= $cashback['available_for_single_user']) {
                $return = false;
            }
        }

        return $return;
    }

    private function check_if_valid_product($product_id, $cashback)
    {
        $return = false;

        if($cashback['apply_cashback_to'] == "all") {
            $return = true;
        } else {
            if($cashback['apply_cashback_to'] == "custom" && in_array($product_id, $cashback['products'])) {
                $return = true;
            }
        }

        return $return;
    }
}