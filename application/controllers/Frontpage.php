<?php defined('BASEPATH') or exit('No direct script access allowed');

class Frontpage extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->model('Artikels');
        $params = array(
            'page_title' => 'Selamat Datang',
            'page_name' => 'frontpage/welcome',
            'current' => array(
                'controller' => 'Frontpage',
                'controller_url' => 'Frontpage'
            ),
            'artikels' => $this->Artikels->find()
        );
        $this->load->view('frontpage', $params);
    }

    function kalkulator()
    {
        if ($this->input->post()) {
            $params['nama'] = $this->input->post('nama');
            $this->load->model('Antropometris');
            $jenis_kelamin = $this->input->post('jenis_kelamin');
            $tgl_lahir = $this->input->post('tgl_lahir');
            $bb = $this->input->post('bb');
            $tb = $this->input->post('tb');
            switch ($this->input->post('jenis_kalkulator')) {
                case 'bb':
                    echo $this->Antropometris->bb($jenis_kelamin, $tgl_lahir, $bb, null);
                    break;
                case 'tb':
                    echo $this->Antropometris->tb($jenis_kelamin, $tgl_lahir, $tb, null);
                    break;
                case 'bbtb':
                    echo $this->Antropometris->gizi($jenis_kelamin, $tgl_lahir, $bb, $tb, null);
                    break;
            }
        } else {
            $params = array(
                'page_title' => 'Kalkulator Gizi',
                'page_name' => 'frontpage/kalkulator',
                'current' => array(
                    'controller' => 'Frontpage',
                    'controller_url' => 'Frontpage/kalkulator'
                ),
                'js' => array(
                    'moment.min.js',
                    'bootstrap-datepicker.js',
                    'daterangepicker.min.js',
                    'select2.full.min.js',
                    'form.js'
                ),
            );
            $this->load->view('frontpage', $params);
        }
    }

    function kalkulator_bumil()
    {
        if ($post = $this->input->post()) {
            foreach (array('umur_kehamilan', 'berat_badan_sebelum_hamil', 'tinggi_badan', 'berat_badan_sekarang') as $input) {
                if (!isset($post[$input]) || $post[$input] === '') $post[$input] = 0;
                // die('{"hasil": "Error: Input Tidak Lengkap"}');
            }
            $result = new stdClass();
            $post['tinggi_badan'] = $post['tinggi_badan'] / 100;
            $post['tinggi_badan'] = pow($post['tinggi_badan'], 2);
            $post['tinggi_badan'] = round($post['tinggi_badan'], 2);

            $result->bmi = $post['tinggi_badan'] === 0 ? 0 : $post['berat_badan_sebelum_hamil'] / $post['tinggi_badan'];
            $result->bmi = round($result->bmi, 2);

            // $result->total_kenaikan_berat_badan = $post['berat_badan_sekarang'] - $post['berat_badan_sebelum_hamil'];

            // $result->rata2_kenaikan_berat_badan_per_minggu = $post['umur_kehamilan'] === 0 ? 0 : $result->total_kenaikan_berat_badan / $post['umur_kehamilan'];
            // $result->rata2_kenaikan_berat_badan_per_minggu = round($result->rata2_kenaikan_berat_badan_per_minggu, 2);

            $ideals = array(
                "Underweight" => array(
                    "penjelasan" => "
                        BMI di bawah 18,5 Angka ini menunjukan Moms underweight atau kekurangan berat badan. Kenaikan berat badan ideal selama hamil adalah 12-18 kg. Ada banyak alasan untuk memiliki BMI rendah. Misalnya mungkin ada alasan medis, seperti tiroid yang terlalu aktif. Jika menurut Moms ini masalahnya, bicarakan dengan bidan atau dokter kandungan. Moms perlu meningkatkan berat badan secepatnya agar mencapai bobot tubuh ideal bagi ibu hamil. Caranya dengan mengonsumsi makanan dalam jumlah kalori yang direkomendasikan. Bila kenaikan berat badan Anda belum cukup cobalah makan dalam jumlah yang lebih banyak sambil tetap menghindari makanan instan. Upayakan menyantap makanan padat nutrisi dan berasal dari sumber yang bervariasi.<br>
                        Misalnya susu rendah lemak, gandum utuh, buah-buahan, dan sayuran. Sehingga Anda dapat menyerap berbagai nutrisi yang dibutuhkan oleh tubuh. Pastikan pula Anda memperoleh asupan kalsium yang cukup, asam folat, zat besi, vitamin A, vitamin D, DHA, dan protein.<br>
                        Berhentilah menenggak minuman beralkohol serta kurangi asupan kafein dan makanan asin. Bila Anda belum juga berhasil menaikkan berat badan sesuai target, berkonsultasilah ke dokter atau ahli gizi untuk membantu merencanakan pola makan yang tepat untuk Anda.
                    ",
                    "total_kenaikan_berat_badan" => "12,5 Kg - 18 Kg",
                    "rata2_kenaikan_berat_badan_per_minggu" => "0,44 Kg/Minggu - 0,58 Kg/Minggu"
                ),
                "Normal Weight" => array(
                    "penjelasan" => "
                        BMI 18.5 sampai 24,9 BMI ini adalah ideal, kenaikan berat badan yang baik adalah 11-16 kg. Pada trimester pertama, kenaikan berat badan ibu hamil sebaiknya 0,5 hingga 2,5 kg. Setelah itu, diikuti dengan kenaikan berat 0,5 kg per minggu.<br>
                        Karena Anda sudah berada pada kenaikan berat badan yang ideal, maka pertahankanlah apa yang sudah Anda lakukan selama ini. Namun, jangan lengah. Tetap Jaga pola makan dan hindari makan berlebihan agar berat badan tetap ideal. Tetap hindari makanan instan dan cemilan yang tidak sehat. Bila ingin ngemil, carilah makanan yang mengandung nutrisi yang baik untuk kehamilan seperti:<br>
                        Kalsium, Folat, Zat besi, Vitamin A, Vitamin C, Vitamin D, Vitamin B6, Vitamin B12
                    ",
                    "total_kenaikan_berat_badan" => "11,5 Kg - 16 Kg",
                    "rata2_kenaikan_berat_badan_per_minggu" => "0,35 Kg/Minggu - 0,5 Kg/Minggu"
                ),
                "Overweight" => array(
                    "penjelasan" => "
                        BMI antara 25 sampai 29,9 Angka ini menunjukkan overweight. Kenaikan berat badan ibu hamil baiknya tidak terlalu banyak. Idealnya adalah 7-11 kg.<br>
                        Dimana Anda akan lebih berisiko mengalami komplikasi kehamilan seperti Diabetes Gestasional. Selain itu, bayi yang lahir dari ibu yang obesitas saat hamil akan lebih berisiko mengalami masalah kesehatan seiring bertambahnya usia. Beberapa masalah yang mungkin terjadi pada anak yang dikandung antara lain di bawah ini.<br>
                        - Kecacatan atau penyakit pada jantung.<br>
                        - Tubuh lebih besar dan gula darah rendah (ini dapat terjadi bila Anda mengalami diabetes gestasional).<br>
                        - Mengalami obesitas, diabetes tipe 2, dan kolesterol tinggi.<br>
                        - Cacat pada tabung saraf seperti spina bifida.<br>
                        Oleh sebab itu, fokuslah memperoleh makanan yang sehat dan bernutrisi. Konsumsilah sayuran, roti gandum utuh, olahan susu rendah lemak, ikan merah tanpa lemak, dan ikan yang mengandung lemak baik. Jenis makanan ini kaya nutrisi tapi tetap mampu menjaga kadar gula darah serta membuat Anda kenyang lebih lama.<br>
                        Berkonsultasilah dengan dokter untuk mengetahui pola diet yang tepat untuk Anda. Tanyakan pula cara yang aman untuk mengontrol kenaikan berat badan Anda serta menjaga agar tidak terkena diabetes gestasional.
                    ",
                    "total_kenaikan_berat_badan" => "7 Kg - 11,5 Kg",
                    "rata2_kenaikan_berat_badan_per_minggu" => "0,23 Kg/Minggu - 0,33 Kg/Minggu"
                ),
                "Obese" => array(
                    "penjelasan" => "BMI di atas 30 Hal ini menunjukkan kondisi obesitas. Kenaikan berat badan ideal adalah 5-9 kg saja.",
                    "total_kenaikan_berat_badan" => "5 Kg - 9 Kg",
                    "rata2_kenaikan_berat_badan_per_minggu" => "0,17 Kg/Minggu - 0,27 Kg/Minggu"
                ),
            );

            if ($result->bmi < 18.5) $result->imt_sebelum_kehamilan = 'Underweight';
            else if ($result->bmi >= 18.5 && $result->bmi <= 24.9) $result->imt_sebelum_kehamilan = 'Normal Weight';
            else if ($result->bmi >= 25 && $result->bmi <= 29.9) $result->imt_sebelum_kehamilan = 'Overweight';
            else if ($result->bmi >= 30) $result->imt_sebelum_kehamilan = 'Obese';

            $result->bmi .= ' Kg/m<sup>2</sup>';
            // $result->total_kenaikan_berat_badan .= ' Kg';
            // $result->rata2_kenaikan_berat_badan_per_minggu .= ' Kg/Minggu';

            $result->penjelasan = $ideals[$result->imt_sebelum_kehamilan]['penjelasan'];
            // $result->total_kenaikan_berat_badan .= " (nilai ideal {$ideals[$result->imt_sebelum_kehamilan]['total_kenaikan_berat_badan']})";
            // $result->rata2_kenaikan_berat_badan_per_minggu .= " (nilai ideal {$ideals[$result->imt_sebelum_kehamilan]['rata2_kenaikan_berat_badan_per_minggu']})";

            echo json_encode($result);
        } else {
            $params = array(
                'page_title' => 'Kalkulator Ibu Hamil',
                'page_name' => 'frontpage/kalkulator_bumil',
                'current' => array(
                    'controller' => 'Frontpage',
                    'controller_url' => 'Frontpage/kalkulator_bumil'
                ),
                'js' => array(
                    'select2.full.min.js',
                    'form.js'
                ),
            );
            $this->load->view('frontpage', $params);
        }
    }

    function imunisasi()
    {
        $params = array(
            'page_title' => 'Jadwal Imunisasi',
            'page_name' => 'frontpage/imunisasi',
        );
        $this->load->model('Menus');
        if ($img = $this->Menus->getImunisasi()) {
            $params['src'] = base_url("imunisasi/{$img}");
        }
        $this->load->view('frontpage', $params);
    }

    function bidan()
    {
        $params = array(
            'page_title' => 'Daftar Bidan',
            'page_name' => 'frontpage/bidan',
            'current' => array(
                'controller' => 'Frontpage',
                'controller_url' => 'Frontpage/bidan_dt'
            ),
            'js' => array(
                'jquery.dataTables.min.js',
                'dataTables.bootstrap4.js',
                'table.js'
            )
        );
        $this->load->view('frontpage', $params);
    }

    function faskes()
    {
        $params = array(
            'page_title' => 'Fasilitas Kesehatan',
            'page_name' => 'frontpage/faskes',
            'current' => array(
                'controller' => 'Frontpage',
                'controller_url' => 'Frontpage/faskes_dt'
            ),
            'js' => array(
                'jquery.dataTables.min.js',
                'dataTables.bootstrap4.js',
                'table.js'
            )
        );
        $this->load->view('frontpage', $params);
    }

    function artikel($uuid)
    {
        $this->load->model('Artikels');
        $artikel = $this->Artikels->findOne($uuid);
        $params = array(
            'page_title' => $artikel['judul'],
            'page_name' => 'frontpage/artikel',
            'current' => array(
                'controller' => 'Frontpage',
                'controller_url' => 'Frontpage/artikel'
            ),
            'artikel' => $artikel
        );
        $this->load->view('frontpage', $params);
    }

    function bidan_dt()
    {
        $this->load->model('Bidans');
        echo $this->Bidans->dt();
    }

    function faskes_dt()
    {
        $this->load->model('Faskess');
        echo $this->Faskess->dt();
    }
    /*
    function parsing_bbtb()
    {
        $xls = "
        0	0,0	43,5	43,6	45,3	45,4	54,7	54,8	~
        1	0,0	47,7	47,8	49,7	49,8	59,5	59,6	~
        2	0,0	50,9	51,0	52,9	53,0	63,2	63,3	~
        3	0,0	53,4	53,5	55,5	55,6	66,1	66,2	~
        4	0,0	55,5	55,6	57,7	57,8	68,6	68,7	~
        5	0,0	57,3	57,4	59,5	59,6	70,7	70,8	~
        6	0,0	58,8	58,9	61,1	61,2	72,5	72,6	~
        7	0,0	60,2	60,3	62,6	62,7	74,2	74,3	~
        8	0,0	61,6	61,7	63,9	64,0	75,8	75,9	~
        9	0,0	62,8	62,9	65,2	65,3	77,4	77,5	~
        10	0,0	64,0	64,1	66,4	66,5	78,9	79,0	~
        11	0,0	65,1	65,2	67,6	67,7	80,3	80,4	~
        12	0,0	66,2	66,3	68,8	68,9	81,7	81,8	~
        13	0,0	67,2	67,3	69,9	70,0	83,1	83,2	~
        14	0,0	68,2	68,3	70,9	71,0	84,4	84,5	~
        15	0,0	69,2	69,3	71,9	72,0	85,7	85,8	~
        16	0,0	70,1	70,2	72,9	73,0	87,0	87,1	~
        17	0,0	71,0	71,1	73,9	74,0	88,2	88,3	~
        18	0,0	71,9	72,0	74,8	74,9	89,4	89,5	~
        19	0,0	72,7	72,8	75,7	75,8	90,6	90,7	~
        20	0,0	73,6	73,7	76,6	76,7	91,7	91,8	~
        21	0,0	74,4	74,5	77,4	77,5	92,9	93,0	~
        22	0,0	75,1	75,2	78,3	78,4	94,0	94,1	~
        23	0,0	75,9	76,0	79,1	79,2	95,0	95,1	~
        24	0,0	76,6	76,7	79,9	80,0	96,1	96,2	~
        25	0,0	76,7	76,8	79,9	80,0	96,4	96,5	~
        26	0,0	77,4	77,5	80,7	80,8	97,4	97,5	~
        27	0,0	78,0	78,1	81,4	81,5	98,4	98,5	~
        28	0,0	78,7	78,8	82,1	82,2	99,4	99,5	~
        29	0,0	79,4	79,5	82,8	82,9	100,3	100,4	~
        30	0,0	80,0	80,1	83,5	83,6	101,3	101,4	~
        31	0,0	80,6	80,7	84,2	84,3	102,2	102,3	~
        32	0,0	81,2	81,3	84,8	84,9	103,1	103,2	~
        33	0,0	81,8	81,9	85,5	85,6	103,9	104,0	~
        34	0,0	82,4	82,5	86,1	86,2	104,8	104,9	~
        35	0,0	83,0	83,1	86,7	86,8	105,6	105,7	~
        36	0,0	83,5	83,6	87,3	87,4	106,5	106,6	~
        37	0,0	84,1	84,2	87,9	88,0	107,3	107,4	~
        38	0,0	84,6	84,7	88,5	88,6	108,1	108,2	~
        39	0,0	85,2	85,3	89,1	89,2	108,9	109,0	~
        40	0,0	85,7	85,8	89,7	89,8	109,7	109,8	~
        41	0,0	86,2	86,3	90,3	90,4	110,5	110,6	~
        42	0,0	86,7	86,8	90,8	90,9	111,2	111,3	~
        43	0,0	87,3	87,4	91,4	91,5	112,0	112,1	~
        44	0,0	87,8	87,9	91,9	92,0	112,7	112,8	~
        45	0,0	88,3	88,4	92,4	92,5	113,5	113,6	~
        46	0,0	88,8	88,9	93,0	93,1	114,2	114,3	~
        47	0,0	89,2	89,3	93,5	93,6	114,9	115,0	~
        48	0,0	89,7	89,8	94,0	94,1	115,7	115,8	~
        49	0,0	90,2	90,3	94,5	94,6	116,4	116,5	~
        50	0,0	90,6	90,7	95,0	95,1	117,1	117,2	~
        51	0,0	91,1	91,2	95,5	95,6	117,7	117,8	~
        52	0,0	91,6	91,7	96,0	96,1	118,4	118,5	~
        53	0,0	92,0	92,1	96,5	96,6	119,1	119,2	~
        54	0,0	92,5	92,6	97,0	97,1	119,8	119,9	~
        55	0,0	92,9	93,0	97,5	97,6	120,4	120,5	~
        56	0,0	93,3	93,4	98,0	98,1	121,1	121,2	~
        57	0,0	93,8	93,9	98,4	98,5	121,8	121,9	~
        58	0,0	94,2	94,3	98,9	99,0	122,4	122,5	~
        59	0,0	94,6	94,7	99,4	99,5	123,1	123,2	~
        60	0,0	95,1	95,2	99,8	99,9	123,7	123,8	~
        ";
        $this->load->model('Antropometris');
        foreach (explode("\n", str_replace("\n[Base Line]", '', $xls)) as $rowIndex => $rowContent) {
            $cell = explode("\t", $rowContent);
            if (!isset($cell[1])) continue;
            $item = 'Tinggi Badan Perempuan';
            $usia_min = trim($cell[0]);
            $bb_min_sangat_kurang = str_replace(',', '.', trim($cell[1]));
            $bb_max_sangat_kurang = str_replace(',', '.', trim($cell[2]));
            $bb_min_kurang = str_replace(',', '.', trim($cell[3]));
            $bb_max_kurang = str_replace(',', '.', trim($cell[4]));
            $bb_min_normal = str_replace(',', '.', trim($cell[5]));
            $bb_max_normal = str_replace(',', '.', trim($cell[6]));
            $bb_min_lebih = str_replace(',', '.', trim($cell[7]));

            $this->Antropometris->create(array(
                'nama' => $item,
                'usia_min' => $usia_min,
                'usia_max' => (int) $usia_min + 1,
                'tb_min' => $bb_min_sangat_kurang,
                'tb_max' => $bb_max_sangat_kurang,
                'hasil' => 'Sangat Pendek',
            ));

            $this->Antropometris->create(array(
                'nama' => $item,
                'usia_min' => $usia_min,
                'usia_max' => (int) $usia_min + 1,
                'tb_min' => $bb_min_kurang,
                'tb_max' => $bb_max_kurang,
                'hasil' => 'Pendek',
            ));

            $this->Antropometris->create(array(
                'nama' => $item,
                'usia_min' => $usia_min,
                'usia_max' => (int) $usia_min + 1,
                'tb_min' => $bb_min_normal,
                'tb_max' => $bb_max_normal,
                'hasil' => 'Normal',
            ));

            $this->Antropometris->create(array(
                'nama' => $item,
                'usia_min' => $usia_min,
                'usia_max' => (int) $usia_min + 1,
                'tb_min' => $bb_min_lebih,
                'tb_max' => 9999,
                'hasil' => 'Tinggi',
            ));
        }
    }

    function parsing_gizi()
    {
        $xls = "
        45,0	0,0	1,8	1,9	1,9	2,0	2,7	2,8	3,0	3,1	3,3	3,4	~
        45,5	0,0	1,8	1,9	2,0	2,1	2,8	2,9	3,1	3,2	3,4	3,5	~
        46,0	0,0	1,9	2,0	2,1	2,2	2,9	3,0	3,1	3,2	3,5	3,6	~
        46,5	0,0	2,0	2,1	2,2	2,3	3,0	3,1	3,2	3,3	3,6	3,7	~
        47,0	0,0	2,0	2,1	2,2	2,3	3,0	3,1	3,3	3,4	3,7	3,8	~
        47,5	0,0	2,1	2,2	2,3	2,4	3,1	3,2	3,4	3,5	3,8	3,9	~
        48,0	0,0	2,2	2,3	2,4	2,5	3,2	3,3	3,6	3,7	3,9	4,0	~
        48,5	0,0	2,2	2,3	2,5	2,6	3,3	3,4	3,7	3,8	4,0	4,1	~
        49,0	0,0	2,3	2,4	2,5	2,6	3,4	3,5	3,8	3,9	4,2	4,3	~
        49,5	0,0	2,4	2,5	2,6	2,7	3,5	3,6	3,9	4,0	4,3	4,4	~
        50,0	0,0	2,5	2,6	2,7	2,8	3,6	3,7	4,0	4,1	4,4	4,5	~
        50,5	0,0	2,6	2,7	2,8	2,9	3,8	3,9	4,1	4,2	4,5	4,6	~
        51,0	0,0	2,6	2,7	2,9	3,0	3,9	4,0	4,2	4,3	4,7	4,8	~
        51,5	0,0	2,7	2,8	3,0	3,1	4,0	4,1	4,4	4,5	4,8	4,9	~
        52,0	0,0	2,8	2,9	3,1	3,2	4,1	4,2	4,5	4,6	5,0	5,1	~
        52,5	0,0	2,9	3,0	3,2	3,3	4,2	4,3	4,6	4,7	5,1	5,2	~
        53,0	0,0	3,0	3,1	3,3	3,4	4,4	4,5	4,8	4,9	5,3	5,4	~
        53,5	0,0	3,1	3,2	3,4	3,5	4,5	4,6	4,9	5,0	5,4	5,5	~
        54,0	0,0	3,2	3,3	3,5	3,6	4,7	4,8	5,1	5,2	5,6	5,7	~
        54,5	0,0	3,3	3,4	3,6	3,7	4,8	4,9	5,3	5,4	5,8	5,9	~
        55,0	0,0	3,5	3,6	3,7	3,8	5,0	5,1	5,4	5,5	6,0	6,1	~
        55,5	0,0	3,6	3,7	3,9	4,0	5,1	5,2	5,6	5,7	6,1	6,2	~
        56,0	0,0	3,7	3,8	4,0	4,1	5,3	5,4	5,8	5,9	6,3	6,4	~
        56,5	0,0	3,8	3,9	4,1	4,2	5,4	5,5	5,9	6,0	6,5	6,6	~
        57,0	0,0	3,9	4,0	4,2	4,3	5,6	5,7	6,1	6,2	6,7	6,8	~
        57,5	0,0	4,0	4,1	4,4	4,5	5,7	5,8	6,3	6,4	6,9	7,0	~
        58,0	0,0	4,2	4,3	4,5	4,6	5,9	6,0	6,4	6,5	7,1	7,2	~
        58,5	0,0	4,3	4,4	4,6	4,7	6,1	6,2	6,6	6,7	7,2	7,3	~
        59,0	0,0	4,4	4,5	4,7	4,8	6,2	6,3	6,8	6,9	7,4	7,5	~
        59,5	0,0	4,5	4,6	4,9	5,0	6,4	6,5	7,0	7,1	7,6	7,7	~
        60,0	0,0	4,6	4,7	5,0	5,1	6,5	6,6	7,1	7,2	7,8	7,9	~
        60,5	0,0	4,7	4,8	5,1	5,2	6,7	6,8	7,3	7,4	8,0	8,1	~
        61,0	0,0	4,8	4,9	5,2	5,3	6,8	6,9	7,4	7,5	8,1	8,2	~
        61,5	0,0	4,9	5,0	5,3	5,4	7,0	7,1	7,6	7,7	8,3	8,4	~
        62,0	0,0	5,0	5,1	5,5	5,6	7,1	7,2	7,7	7,8	8,5	8,6	~
        62,5	0,0	5,1	5,2	5,6	5,7	7,2	7,3	7,9	8,0	8,6	8,7	~
        63,0	0,0	5,2	5,3	5,7	5,8	7,4	7,5	8,0	8,1	8,8	8,9	~
        63,5	0,0	5,3	5,4	5,8	5,9	7,5	7,6	8,2	8,3	8,9	9,0	~
        64,0	0,0	5,4	5,5	5,9	6,0	7,6	7,7	8,3	8,4	9,1	9,2	~
        64,5	0,0	5,5	5,6	6,0	6,1	7,8	7,9	8,5	8,6	9,3	9,4	~
        65,0	0,0	5,6	5,7	6,1	6,2	7,9	8,0	8,6	8,7	9,4	9,5	~
        65,5	0,0	5,7	5,8	6,2	6,3	8,0	8,1	8,7	8,8	9,6	9,7	~
        66,0	0,0	5,8	5,9	6,3	6,4	8,2	8,3	8,9	9,0	9,7	9,8	~
        66,5	0,0	5,9	6,0	6,4	6,5	8,3	8,4	9,0	9,1	9,9	10,0	~
        67,0	0,0	6,0	6,1	6,5	6,6	8,4	8,5	9,2	9,3	10,0	10,1	~
        67,5	0,0	6,1	6,2	6,6	6,7	8,5	8,6	9,3	9,4	10,2	10,3	~
        68,0	0,0	6,2	6,3	6,7	6,8	8,7	8,8	9,4	9,5	10,3	10,4	~
        68,5	0,0	6,3	6,4	6,8	6,9	8,8	8,9	9,6	9,7	10,5	10,6	~
        69,0	0,0	6,4	6,5	6,9	7,0	8,9	9,0	9,7	9,8	10,6	10,7	~
        69,5	0,0	6,5	6,6	7,0	7,1	9,0	9,1	9,8	9,9	10,8	10,9	~
        70,0	0,0	6,5	6,6	7,1	7,2	9,2	9,3	10,0	10,1	10,9	11,0	~
        70,5	0,0	6,6	6,7	7,2	7,3	9,3	9,4	10,1	10,2	11,1	11,2	~
        71,0	0,0	6,7	6,8	7,3	7,4	9,4	9,5	10,2	10,3	11,2	11,3	~
        71,5	0,0	6,8	6,9	7,4	7,5	9,5	9,6	10,4	10,5	11,3	11,4	~
        72,0	0,0	6,9	7,0	7,5	7,6	9,6	9,7	10,5	10,6	11,5	11,6	~
        72,5	0,0	7,0	7,1	7,5	7,6	9,8	9,9	10,6	10,7	11,6	11,7	~
        73,0	0,0	7,1	7,2	7,6	7,7	9,9	10,0	10,8	10,9	11,8	11,9	~
        73,5	0,0	7,1	7,2	7,7	7,8	10,0	10,1	10,9	11,0	11,9	12,0	~
        74,0	0,0	7,2	7,3	7,8	7,9	10,1	10,2	11,0	11,1	12,1	12,2	~
        74,5	0,0	7,3	7,4	7,9	8,0	10,2	10,3	11,2	11,3	12,2	12,3	~
        75,0	0,0	7,4	7,5	8,0	8,1	10,3	10,4	11,3	11,4	12,3	12,4	~
        75,5	0,0	7,5	7,6	8,1	8,2	10,4	10,5	11,4	11,5	12,5	12,6	~
        76,0	0,0	7,5	7,6	8,2	8,3	10,6	10,7	11,5	11,6	12,6	12,7	~
        76,5	0,0	7,6	7,7	8,2	8,3	10,7	10,8	11,6	11,7	12,7	12,8	~
        77,0	0,0	7,7	7,8	8,3	8,4	10,8	10,9	11,7	11,8	12,8	12,9	~
        77,5	0,0	7,8	7,9	8,4	8,5	10,9	11,0	11,9	12,0	13,0	13,1	~
        78,0	0,0	7,8	7,9	8,5	8,6	11,0	11,1	12,0	12,1	13,1	13,2	~
        78,5	0,0	7,9	8,0	8,6	8,7	11,1	11,2	12,1	12,2	13,2	13,3	~
        79,0	0,0	8,0	8,1	8,6	8,7	11,2	11,3	12,2	12,3	13,3	13,4	~
        79,5	0,0	8,1	8,2	8,7	8,8	11,3	11,4	12,3	12,4	13,4	13,5	~
        80,0	0,0	8,1	8,2	8,8	8,9	11,4	11,5	12,4	12,5	13,6	13,7	~
        80,5	0,0	8,2	8,3	8,9	9,0	11,5	11,6	12,5	12,6	13,7	13,8	~
        81,0	0,0	8,3	8,4	9,0	9,1	11,6	11,7	12,6	12,7	13,8	13,9	~
        81,5	0,0	8,4	8,5	9,0	9,1	11,7	11,8	12,7	12,8	13,9	14,0	~
        82,0	0,0	8,4	8,5	9,1	9,2	11,8	11,9	12,8	12,9	14,0	14,1	~
        82,5	0,0	8,5	8,6	9,2	9,3	11,9	12,0	13,0	13,1	14,2	14,3	~
        83,0	0,0	8,6	8,7	9,3	9,4	12,0	12,1	13,1	13,2	14,3	14,4	~
        83,5	0,0	8,7	8,8	9,4	9,5	12,1	12,2	13,2	13,3	14,4	14,5	~
        84,0	0,0	8,8	8,9	9,5	9,6	12,2	12,3	13,3	13,4	14,6	14,7	~
        84,5	0,0	8,9	9,0	9,6	9,7	12,4	12,5	13,5	13,6	14,7	14,8	~
        85,0	0,0	9,0	9,1	9,7	9,8	12,5	12,6	13,6	13,7	14,9	15,0	~
        85,5	0,0	9,1	9,2	9,8	9,9	12,6	12,7	13,7	13,8	15,0	15,1	~
        86,0	0,0	9,2	9,3	9,9	10,0	12,8	12,9	13,9	14,0	15,2	15,3	~
        86,5	0,0	9,3	9,4	10,0	10,1	12,9	13,0	14,0	14,1	15,3	15,4	~
        87,0	0,0	9,4	9,5	10,1	10,2	13,0	13,1	14,2	14,3	15,5	15,6	~
        87,5	0,0	9,5	9,6	10,3	10,4	13,2	13,3	14,3	14,4	15,6	15,7	~
        88,0	0,0	9,6	9,7	10,4	10,5	13,3	13,4	14,5	14,6	15,8	15,9	~
        88,5	0,0	9,7	9,8	10,5	10,6	13,4	13,5	14,6	14,7	15,9	16,0	~
        89,0	0,0	9,8	9,9	10,6	10,7	13,5	13,6	14,7	14,8	16,1	16,2	~
        89,5	0,0	9,9	10,0	10,7	10,8	13,7	13,8	14,9	15,0	16,2	16,3	~
        90,0	0,0	10,0	10,1	10,8	10,9	13,8	13,9	15,0	15,1	16,4	16,5	~
        90,5	0,0	10,1	10,2	10,9	11,0	13,9	14,0	15,1	15,2	16,5	16,6	~
        91,0	0,0	10,2	10,3	11,0	11,1	14,1	14,2	15,3	15,4	16,7	16,8	~
        91,5	0,0	10,3	10,4	11,1	11,2	14,2	14,3	15,4	15,5	16,8	16,9	~
        92,0	0,0	10,4	10,5	11,2	11,3	14,3	14,4	15,6	15,7	17,0	17,1	~
        92,5	0,0	10,5	10,6	11,3	11,4	14,4	14,5	15,7	15,8	17,1	17,2	~
        93,0	0,0	10,6	10,7	11,4	11,5	14,6	14,7	15,8	15,9	17,3	17,4	~
        93,5	0,0	10,6	10,7	11,5	11,6	14,7	14,8	16,0	16,1	17,4	17,5	~
        94,0	0,0	10,7	10,8	11,6	11,7	14,8	14,9	16,1	16,2	17,6	17,7	~
        94,5	0,0	10,8	10,9	11,7	11,8	14,9	15,0	16,3	16,4	17,7	17,8	~
        95,0	0,0	10,9	11,0	11,8	11,9	15,1	15,2	16,4	16,5	17,9	18,0	~
        95,5	0,0	11,0	11,1	11,9	12,0	15,2	15,3	16,5	16,6	18,0	18,1	~
        96,0	0,0	11,1	11,2	12,0	12,1	15,3	15,4	16,7	16,8	18,2	18,3	~
        96,5	0,0	11,2	11,3	12,1	12,2	15,5	15,6	16,8	16,9	18,4	18,5	~
        97,0	0,0	11,3	11,4	12,2	12,3	15,6	15,7	17,0	17,1	18,5	18,6	~
        97,5	0,0	11,4	11,5	12,3	12,4	15,7	15,8	17,1	17,2	18,7	18,8	~
        98,0	0,0	11,5	11,6	12,4	12,5	15,9	16,0	17,3	17,4	18,9	19,0	~
        98,5	0,0	11,6	11,7	12,5	12,6	16,0	16,1	17,5	17,6	19,1	19,2	~
        99,0	0,0	11,7	11,8	12,6	12,7	16,2	16,3	17,6	17,7	19,2	19,3	~
        99,5	0,0	11,8	11,9	12,7	12,8	16,3	16,4	17,8	17,9	19,4	19,5	~
        100,0	0,0	11,9	12,0	12,8	12,9	16,5	16,6	18,0	18,1	19,6	19,7	~
        100,5	0,0	12,0	12,1	12,9	13,0	16,6	16,7	18,1	18,2	19,8	19,9	~
        101,0	0,0	12,1	12,2	13,1	13,2	16,8	16,9	18,3	18,4	20,0	20,1	~
        101,5	0,0	12,2	12,3	13,2	13,3	16,9	17,0	18,5	18,6	20,2	20,3	~
        102,0	0,0	12,3	12,4	13,3	13,4	17,1	17,2	18,7	18,8	20,4	20,5	~
        102,5	0,0	12,4	12,5	13,4	13,5	17,3	17,4	18,8	18,9	20,6	20,7	~
        103,0	0,0	12,5	12,6	13,5	13,6	17,4	17,5	19,0	19,1	20,8	20,9	~
        103,5	0,0	12,6	12,7	13,6	13,7	17,6	17,7	19,2	19,3	21,0	21,1	~
        104,0	0,0	12,7	12,8	13,8	13,9	17,8	17,9	19,4	19,5	21,2	21,3	~
        104,5	0,0	12,8	12,9	13,9	14,0	17,9	18,0	19,6	19,7	21,5	21,6	~
        105,0	0,0	12,9	13,0	14,0	14,1	18,1	18,2	19,8	19,9	21,7	21,8	~
        105,5	0,0	13,1	13,2	14,1	14,2	18,3	18,4	20,0	20,1	21,9	22,0	~
        106,0	0,0	13,2	13,3	14,3	14,4	18,5	18,6	20,2	20,3	22,1	22,2	~
        106,5	0,0	13,3	13,4	14,4	14,5	18,6	18,7	20,4	20,5	22,4	22,5	~
        107,0	0,0	13,4	13,5	14,5	14,6	18,8	18,9	20,6	20,7	22,6	22,7	~
        107,5	0,0	13,5	13,6	14,6	14,7	19,0	19,1	20,8	20,9	22,8	22,9	~
        108,0	0,0	13,6	13,7	14,8	14,9	19,2	19,3	21,0	21,1	23,1	23,2	~
        108,5	0,0	13,7	13,8	14,9	15,0	19,4	19,5	21,2	21,3	23,3	23,4	~
        109,0	0,0	13,9	14,0	15,0	15,1	19,6	19,7	21,4	21,5	23,6	23,7	~
        109,5	0,0	14,0	14,1	15,2	15,3	19,8	19,9	21,7	21,8	23,8	23,9	~
        110,0	0,0	14,1	14,2	15,3	15,4	20,0	20,1	21,9	22,0	24,1	24,2	~
        ";
        $this->load->model('Antropometris');
        foreach (explode("\n", str_replace("\n[Base Line]", '', $xls)) as $rowIndex => $rowContent) {
            $cell = explode("\t", $rowContent);
            if (!isset($cell[1])) continue;
            $nama = 'Gizi Lelaki';
            $usia_min = 0;
            $usia_max = 24;
            $tb_min = str_replace(',', '.', trim($cell[0]));
            $bb_min_buruk = str_replace(',', '.', trim($cell[1]));
            $bb_max_buruk = str_replace(',', '.', trim($cell[2]));
            $bb_min_kurang = str_replace(',', '.', trim($cell[3]));
            $bb_max_kurang = str_replace(',', '.', trim($cell[4]));
            $bb_min_baik = str_replace(',', '.', trim($cell[5]));
            $bb_max_baik = str_replace(',', '.', trim($cell[6]));
            $bb_min_lebih = str_replace(',', '.', trim($cell[7]));
            $bb_max_lebih = str_replace(',', '.', trim($cell[8]));
            $bb_min_obesitas = str_replace(',', '.', trim($cell[9]));
            $bb_max_obesitas = 9999;

            $this->Antropometris->create(array(
                'nama' => $nama,
                'usia_min' => $usia_min,
                'usia_max' => $usia_max,
                'bb_min' => $bb_min_buruk,
                'bb_max' => $bb_max_buruk,
                'tb_min' => $tb_min,
                'tb_max' => (float) $tb_min + 0.4,
                'hasil' => 'Gizi Buruk',
            ));

            $this->Antropometris->create(array(
                'nama' => $nama,
                'usia_min' => $usia_min,
                'usia_max' => $usia_max,
                'bb_min' => $bb_min_kurang,
                'bb_max' => $bb_max_kurang,
                'tb_min' => $tb_min,
                'tb_max' => (float) $tb_min + 0.4,
                'hasil' => 'Gizi Kurang',
            ));

            $this->Antropometris->create(array(
                'nama' => $nama,
                'usia_min' => $usia_min,
                'usia_max' => $usia_max,
                'bb_min' => $bb_min_baik,
                'bb_max' => $bb_max_baik,
                'tb_min' => $tb_min,
                'tb_max' => (float) $tb_min + 0.4,
                'hasil' => 'Gizi Baik',
            ));

            $this->Antropometris->create(array(
                'nama' => $nama,
                'usia_min' => $usia_min,
                'usia_max' => $usia_max,
                'bb_min' => $bb_min_lebih,
                'bb_max' => $bb_max_lebih,
                'tb_min' => $tb_min,
                'tb_max' => (float) $tb_min + 0.4,
                'hasil' => 'Gizi Lebih',
            ));

            $this->Antropometris->create(array(
                'nama' => $nama,
                'usia_min' => $usia_min,
                'usia_max' => $usia_max,
                'bb_min' => $bb_min_obesitas,
                'bb_max' => $bb_max_obesitas,
                'tb_min' => $tb_min,
                'tb_max' => (float) $tb_min + 0.4,
                'hasil' => 'Obesitas',
            ));
        }
    }
*/
}
