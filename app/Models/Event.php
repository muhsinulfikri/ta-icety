<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'ID_EVENT';
    public $timestamps = false;
    function __construct()
    {
        parent::__construct();
        DB::statement("SET foreign_key_checks = 0;");
    }
    public function get_home_event()
    {
        $data = DB::select("
        SELECT 
            * 
        FROM 
            activity 
        WHERE 
            TYPE_ACTIVITY = 2
            AND
            STATUS = 1
        ORDER BY 
            LOG_TIME DESC 
        LIMIT 4
        ");

        // $this->db->limit(3);
        // $this->db->order_by('activity.LOG_TIME', 'desc');
        return $data;
    }
    public function get_all_event()
    {
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 2])->result_array();
    }
    public function get_all_event_in($id)
    {
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 2, 'ID_USER' => $id])->result_array();
    }
    public function get_event_by_id($keyword, $type)
    {
        $query = DB::table('activity')->select('*');


        if (!empty($keyword)) {
            $query->where('TITLE_ACTIVITY', 'like', '%' . $keyword . '%');
        }

        $query->where('TYPE_ACTIVITY', $type);

        return $query->get()->toArray();
    }
    public function get_event_pagination($start = "")
    {
        $data['query'] = DB::select("
        SELECT 
            activity.*,
            (DATEDIFF(CURDATE(), activity.DATE_START) >= 1) as EXPIRED
            FROM 
                activity
            LIMIT 
                $start;
        ");

        $data['total_row'] = DB::SelectOne('
			SELECT
				COUNT(ID_ACTIVITY) as TOTAL_ROW
			FROM
				activity
			WHERE
				TYPE_ACTIVITY = 2
		');
        return $data;
    }
    public function get_other_event($id_activity)
    {
        $data = DB::select('
        SELECT 
            activity.*,
            DATEDIFF(CURDATE(), activity.DATE_START) >= 1 AS EXPIRED
        FROM 
            activity
        WHERE 
            activity.TYPE_ACTIVITY = 2
            AND activity.ID_ACTIVITY <> "' . $id_activity . '"
        ORDER BY RAND()
        LIMIT 6;
        ');
        return $data;
    }
    public function get_event($id_activity)
    {
        if (!empty(session('user'))) {
            $data = DB::selectOne('
            SELECT 
                activity.*, 
                event.ID_EVENT, 
                event.CATEGORY_EVENT, 
                event.LOCATION, 
                event.ORGANIZER, 
                event.CONTACT_CUSTOMER, 
                event.DESKRIPSI_EVENT, 
                event.LINK_ZOOM,
                (SELECT COUNT(*)
                    FROM payment p
                    LEFT JOIN `order` o ON o.ID_PAY = p.ID_PAY 
                    WHERE o.ID_USER = "' . session('user')[0]->get('ID_USER') . '"
                    AND o.ID_PRODUCT = "' . $id_activity . '"
                    AND p.DATE_PAY IS NOT NULL) as DATA_CHECKING,
                (DATEDIFF(CURDATE(), activity.DATE_START) >= 1) as EXPIRED
            FROM activity
            LEFT OUTER JOIN event ON event.ID_ACTIVITY = activity.ID_ACTIVITY
            WHERE activity.TYPE_ACTIVITY = 2
            AND activity.ID_ACTIVITY = "' . $id_activity . '"
            ');
            return $data;
        } else {
            $data = DB::selectOne('
            SELECT 
                activity.*, 
                event.ID_EVENT, 
                event.CATEGORY_EVENT, 
                event.LOCATION, 
                event.ORGANIZER, 
                event.CONTACT_CUSTOMER, 
                event.DESKRIPSI_EVENT, 
                event.LINK_ZOOM,
                DATEDIFF(CURDATE(), activity.DATE_START) >= 1 AS EXPIRED
            FROM 
                activity
            LEFT OUTER JOIN 
                event ON event.ID_ACTIVITY = activity.ID_ACTIVITY
            WHERE 
                activity.TYPE_ACTIVITY = 2 
                AND activity.ID_ACTIVITY = "' . $id_activity . '"
            ');
            return $data;
        }
    }
    public function InsertActivity($data)
    {
        $this->db->insert('activity', $data);
        return $this->db->affected_rows();
    }
    public function InsertEvent($data)
    {
        $this->db->insert('event', $data);
        return $this->db->affected_rows();
    }
    public function UpdateActivity($data, $id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->update('activity', $data);
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function UpdateEvent($data, $id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->update('event', $data);
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteActivity($id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->delete('activity');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteEvent($id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->delete('event');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
}
