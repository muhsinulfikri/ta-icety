<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Checkout extends Model
{
    use HasFactory;
    protected $table = 'order';
    public $timestamps = false;
    protected $primaryKey = 'ID_ORDER';
    
    public function get_all_order($id_user)
    {
        $sql = "
            SELECT
                `order`.*,
                activity.TITLE_ACTIVITY,
                activity.IMAGE_ACTIVITY,
                ebook.JUDUL,
                ebook.IMAGE_EBOOK
            FROM
                `order`
            LEFT JOIN
                activity ON activity.ID_ACTIVITY = `order`.ID_PRODUCT
            LEFT JOIN
                ebook ON ebook.ID_BUKU = `order`.ID_PRODUCT
            WHERE
                `order`.ID_USER = '" . $id_user . "'
                AND
                `order`.ID_PAY IS NULL
        ";

        return DB::select($sql);
    }

    public function get_trans($id_user)
    {
        return DB::select("
            SELECT
                p.*,
                o.ID_ORDER ,
                o.ID_PRODUCT ,
                o.PRICE_ORDER ,
                a.IMAGE_ACTIVITY ,
                a.TITLE_ACTIVITY ,
                pm.STATUS,
                pm.ID_PAY_METHOD
            FROM
                payment p
            LEFT JOIN `order` o ON
                o.ID_PAY = p.ID_PAY
            LEFT JOIN activity a ON
                a.ID_ACTIVITY = o.ID_PRODUCT
            LEFT JOIN payment_method pm ON
                pm.ID_PAY = p.ID_PAY
            WHERE
                pm.STATUS = 'PENDING'
                AND
                p.KODE_USER = '$id_user'
        ");
    }

    public function get_detail_order($id_order, $id_activity)
    {
        $userId = !empty(session('user')[0]['ID_USER']) ? session('user')[0]['ID_USER'] : null;

        $OrderIDCheck = "";
        $ProductIDCheck = "";
        if (!empty($id_order)) {
            if (is_array($id_order)) {
                $id_order_array = array_map(function ($id) {
                    return "'" . addslashes($id) . "'";
                }, $id_order);
                $cnvrtOrderID = implode(",", $id_order_array);
                $OrderIDCheck = "AND `order`.ID_ORDER IN ($cnvrtOrderID)";
            } else {
                $OrderIDCheck = "AND `order`.ID_ORDER = '$id_order'";
            }
        }
        if (!empty($id_activity)) {
            if (is_array($id_activity)) {
                $id_act_array = array_map(function ($id) {
                    return "'" . addslashes($id) . "'";
                }, $id_activity);
                $cnvrtActID = implode(",", $id_act_array);
                $ProductIDCheck = "AND `order`.ID_PRODUCT IN ($cnvrtActID)";
            } else {
                $ProductIDCheck = "AND `order`.ID_PRODUCT = '$id_activity'";
            }
        }

        $sql = "
            SELECT
                `order`.*,
                activity.TITLE_ACTIVITY,
                activity.IMAGE_ACTIVITY,
                ebook.JUDUL,
                ebook.IMAGE_EBOOK
            FROM
                `order`
            LEFT JOIN
                activity ON activity.ID_ACTIVITY = `order`.ID_PRODUCT
            LEFT JOIN
                ebook ON ebook.ID_BUKU = `order`.ID_PRODUCT
            WHERE
                `order`.ID_USER = '$userId'
                " . $OrderIDCheck . "
                " . $ProductIDCheck . "
        ";

        $queryResult = DB::select($sql);

        return !empty($id_activity) ? (count($queryResult) > 0 ? $queryResult[0] : null) : $queryResult;
    }

    // INSERT FUNCTION
    public function insert_payment($data)
    {
        $this->db->insert('payment', $data);
    }

    public function insert_payment_method($data)
    {
        $this->db->insert('payment_method', $data);
    }

    public function insert_order($data)
    {
        $this->db->insert('order', $data);
    }

    public function insert_transaction($data)
    {
        $this->db->insert('transaction', $data);
    }

    public function insert_mapping($data)
    {
        $this->db->insert('mapping_course', $data);
    }

    // UPDATE FUNCTION
    public function update_payment_method($data, $id_pay_method)
    {
        $this->db->where('payment_method.ID_PAY_METHOD', $id_pay_method);
        $this->db->update('payment_method', $data);
    }

    public function update_payment($data, $id_pay)
    {
        $this->db->where('payment.ID_PAY', $id_pay);
        $this->db->update('payment', $data);
    }

    public function update_order($data, $id_activity, $id_user)
    {
        $this->db->where('order.ID_PRODUCT', $id_activity);
        $this->db->where('order.ID_USER', $id_user);
        $this->db->update('order', $data);
    }

    // DELETE FUNCTION
    public function delete_transaction($id_trans, $id_order)
    {
        $this->db->where('order.PRICE_ORDER <> 0');
        $this->db->where_in('order.ID_ORDER', $id_order);
        $this->db->update('order', ['ID_PAY' => NULL]);

        $this->db->where('payment_method.ID_PAY', $id_trans);
        $this->db->delete('payment_method');

        $this->db->where('payment.ID_PAY', $id_trans);
        $this->db->delete('payment');
    }

    public function delete_order($id_order)
    {
        $this->db->where('ID_ORDER', $id_order);
        $this->db->delete('order');
    }
}
