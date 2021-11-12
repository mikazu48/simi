<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('Pdf');
    $this->load->model('M_admin');
  }

  public function barangKeluarManual()
  {

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // document informasi
    $pdf->SetCreator('Web Aplikasi Gudang');
    $pdf->SetTitle('Laporan Data Barang Keluar');
    $pdf->SetSubject('Barang Keluar');

    //header Data
    $pdf->SetHeaderData('logo.ico',30,'Laporan Data','Barang Keluar',array(203, 58, 44),array(0, 0, 0));
    $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margin
    $pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP + 10,PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

    //SET Scaling ImagickPixel
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //FONT Subsetting
    $pdf->setFontSubsetting(true);

    $pdf->SetFont('helvetica','',12,'',true);

    $pdf->AddPage('L');

    $html=
      '<div>
        <h1 align="center">Invoice Bukti Pengeluaran Barang</h1>
        <p>No Id Transaksi  :</p>
        <p>Ditunjukan Untuk :</p>
        <p>Tanggal          :</p>
        <p>Po.Customer      :</p>


        <table border="1">
          <tr>
            <th style="width:40px" align="center">No</th>
            <th style="width:110px" align="center">ID Transaksi</th>
            <th style="width:110px" align="center">Tanggal Masuk</th>
            <th style="width:110px" align="center">Tanggal Keluar</th>
            <th style="width:130px" align="center">Lokasi</th>
            <th style="width:140px" align="center">Kode Barang</th>
            <th style="width:140px" align="center">Nama Barang</th>
            <th style="width:80px" align="center">Satuan</th>
            <th style="width:80px" align="center">Jumlah</th>
          </tr>';

        $html .= '<tr>
                    <td style="height:180px"></td>
                    <td  style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                    <td style="height:180px"></td>
                 </tr>
                 <tr>
                  <td align="center" colspan="8">Jumlah</td>
                  <td></td>
                 </tr>';



        $html .='
            </table>
            <h6>Mengetahui</h6><br>
            <h6>Admin</h6>
          </div>';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

    $pdf->Output('contoh_report.pdf','I');
  }

  public function barangKeluar()
  {
    $id = $this->uri->segment(3);
    $tgl1 = $this->uri->segment(4);
    $tgl2 = $this->uri->segment(5);
    $tgl3 = $this->uri->segment(6);
    $ls   = array('id_transaksi' => $id ,'tanggal_keluar' => $tgl1.'/'.$tgl2.'/'.$tgl3);
    $data = $this->M_admin->report_data_barang_keluar($id,$tgl1);

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // document informasi
    $pdf->SetCreator('Web Aplikasi Gudang');
    $pdf->SetTitle('Laporan Data Barang Keluar');
    $pdf->SetSubject('Barang Keluar');

    //header Data
    $pdf->SetHeaderData('logo.ico',30,'Laporan Data','Barang Keluar',array(203, 58, 44),array(0, 0, 0));
    $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margin
    $pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP + 10,PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

    //SET Scaling ImagickPixel
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //FONT Subsetting
    $pdf->setFontSubsetting(true);

    $pdf->SetFont('helvetica','',12,'',true);

    $pdf->AddPage('L');

    $html=
      '<div>
        <h1 align="center">Invoice Bukti Pengeluaran Barang</h1><br>
        <p>No Id Transaksi  : '.$id.'</p>
        <p>Ditunjukan Untuk :</p>
        <p>Tanggal          : '.$tgl1.'</p>
        <p>Po.Customer      :</p>


        <table border="1">
          <tr>
            <th style="width:40px" align="center">No</th>
            <th style="width:110px" align="center">ID Transaksi</th>
            <th style="width:110px" align="center">Tanggal Keluar</th>
            <th style="width:130px" align="center">Lokasi</th>
            <th style="width:140px" align="center">Kode Barang</th>
            <th style="width:140px" align="center">Nama Barang</th>
            <th style="width:80px" align="center">Satuan</th>
            <th style="width:80px" align="center">Jumlah</th>
          </tr>';


          $no = 1;
          $JumlahSemua = 0;
          foreach($data as $d){
            $JumlahSemua += $d->jumlah;
            $html .= '<tr>';
            $html .= '<td align="center">'.$no.'</td>';
            $html .= '<td align="center">'.$d->id_transaksi.'</td>';
            $html .= '<td align="center">'.$d->tanggal_keluar.'</td>';
            $html .= '<td align="center">'.$d->lokasi.'</td>';
            $html .= '<td align="center">'.$d->id_barang.'</td>';
            $html .= '<td align="center">'.$d->nama_barang.'</td>';
            $html .= '<td align="center">'.$d->satuan.'</td>';
            $html .= '<td align="center">'.$d->jumlah.'</td>';
            $html .= '</tr>';

            $no++;
          }
            $html .= '<tr>';
            $html .= '<td align="center" colspan="7"><b>Jumlah</b></td>';
            $html .= '<td align="center">'.$JumlahSemua.'</td>';
            $html .= '</tr>';


        $html .='
            </table><br>
            <h6>Mengetahui</h6><br><br><br>
            <h6>Admin</h6>
          </div>';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

    $pdf->Output('invoice_barang_keluar.pdf','I');

  }
  
  public function akumulasi_stock_barangKeluar()
  {
    $tahun = $this->uri->segment(3);    
    $data = $this->M_admin->report_akumulasi_barang_keluar($tahun);
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // document informasi
    $pdf->SetCreator('Web Aplikasi Gudang');
    $pdf->SetTitle('Laporan Akumulasi Barang Keluar');
    $pdf->SetSubject('Barang Keluar');

    //header Data
    $pdf->SetHeaderData('logo.ico',30,'Laporan Data','Barang Keluar',array(203, 58, 44),array(0, 0, 0));
    $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margin
    $pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP + 10,PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

    //SET Scaling ImagickPixel
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //FONT Subsetting
    $pdf->setFontSubsetting(true);

    $pdf->SetFont('helvetica','',12,'',true);

    $pdf->AddPage('L');

    $html=
      '<div>
        <h1 align="center">Laporan Akumulasi Barang Keluar</h1><br>
        <p>Tahun          : '.$tahun.'</p>
        <p>Ditunjukan Untuk :</p>
        <p>Po.Customer      :</p>';

        $temp_html=
        '<p></p>
        <table border="1">
          <tr>
            <th style="width:50px" align="center">No.</th>
            <th style="width:70px" align="center">Tahun</th>
            <th style="width:100px" align="center">Kode Barang</th>
            <th style="width:450px" align="center">Nama Barang</th>
            <th style="width:70px" align="center">Satuan</th>
            <th style="width:70px" align="center">Stok</th>
            <th style="width:80px" align="center">Akumulasi Jumlah</th>
          </tr>';
          $html .= $temp_html;

          $max_row = 15;
          $no = 1;
          $JumlahSemua = 0;

          foreach($data as $d){
            $JumlahSemua += $d->akumulasi_tahun;
          }
          $temp_jumlah = $max_row;

          foreach($data as $d){
            $html .= '<tr>';
            $html .= '<td align="center">'.$no.'</td>';
            $html .= '<td align="center">'.$tahun.'</td>';
            $html .= '<td align="center">'.$d->id_barang.'</td>';
            $html .= '<td align="center">'.$d->nama_barang.'</td>';
            $html .= '<td align="center">'.$d->satuan.'</td>';
            $html .= '<td align="center">'.$d->stok.'</td>';
            $html .= '<td align="center">'.$d->akumulasi_tahun.'</td>';
            $html .= '</tr>';
            $no++;
            
            if($no > $temp_jumlah){
              $html .='</table></div>';
              $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);
              $pdf->AddPage('L');
              $html = $temp_html;
              $temp_jumlah += $max_row;
            }
          }
            $html .= '<tr>';
            $html .= '<td align="center" colspan="6"><b>Jumlah</b></td>';
            $html .= '<td align="center">'.$JumlahSemua.'</td>';
            $html .= '</tr>';

            $html .='
            </table>
            <h4>Total Barang : '.($no-1).'</h4> <br>
            <h6>Mengetahui</h6><br><br><br>
            <h6>Admin</h6>
          </div>';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

    $pdf->Output('akumulasi_barang_keluar.pdf','I');

  }
  public function akumulasi_stock_barangMasuk()
  {
    $tahun = $this->uri->segment(3);    
    $data = $this->M_admin->report_akumulasi_barang_masuk($tahun);
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // document informasi
    $pdf->SetCreator('Web Aplikasi Gudang');
    $pdf->SetTitle('Laporan Akumulasi Barang Masuk');
    $pdf->SetSubject('Barang masuk');

    //header Data
    $pdf->SetHeaderData('logo.ico',30,'Laporan Data','Barang Masuk',array(203, 58, 44),array(0, 0, 0));
    $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margin
    $pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP + 10,PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

    //SET Scaling ImagickPixel
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //FONT Subsetting
    $pdf->setFontSubsetting(true);

    $pdf->SetFont('helvetica','',12,'',true);

    $pdf->AddPage('L');

    $html=
      '<div>
        <h1 align="center">Laporan Akumulasi Barang Masuk</h1><br>
        <p>Tahun          : '.$tahun.'</p>
        <p>Ditunjukan Untuk :</p>
        <p>Po.Customer      :</p>';

        $temp_html=
        '<p></p>
        <table border="1">
          <tr>
            <th style="width:50px" align="center">No.</th>
            <th style="width:70px" align="center">Tahun</th>
            <th style="width:100px" align="center">Kode Barang</th>
            <th style="width:450px" align="center">Nama Barang</th>
            <th style="width:70px" align="center">Satuan</th>
            <th style="width:70px" align="center">Stok</th>
            <th style="width:80px" align="center">Akumulasi Jumlah</th>
          </tr>';
          $html .= $temp_html;

          $max_row = 15;
          $no = 1;
          $JumlahSemua = 0;

          foreach($data as $d){
            $JumlahSemua += $d->akumulasi_tahun;
          }
          $temp_jumlah = $max_row;

          foreach($data as $d){
            $html .= '<tr>';
            $html .= '<td align="center">'.$no.'</td>';
            $html .= '<td align="center">'.$tahun.'</td>';
            $html .= '<td align="center">'.$d->id_barang.'</td>';
            $html .= '<td align="center">'.$d->nama_barang.'</td>';
            $html .= '<td align="center">'.$d->satuan.'</td>';
            $html .= '<td align="center">'.$d->stok.'</td>';
            $html .= '<td align="center">'.$d->akumulasi_tahun.'</td>';
            $html .= '</tr>';
            $no++;
            
            if($no > $temp_jumlah){
              $html .='</table></div>';
              $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);
              $pdf->AddPage('L');
              $html = $temp_html;
              $temp_jumlah += $max_row;
            }
          }
            $html .= '<tr>';
            $html .= '<td align="center" colspan="6"><b>Jumlah</b></td>';
            $html .= '<td align="center">'.$JumlahSemua.'</td>';
            $html .= '</tr>';

            $html .='
            </table>
            <h4>Total Barang : '.($no-1).'</h4> <br>
            <h6>Mengetahui</h6><br><br><br>
            <h6>Admin</h6>
          </div>';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

    $pdf->Output('akumulasi_barang_masuk.pdf','I');

  }

  public function barangmasuk()
  {
    $id = $this->uri->segment(3);
    $tgl1 = $this->uri->segment(4);
    $tgl2 = $this->uri->segment(5);
    $tgl3 = $this->uri->segment(6);
    $ls   = array('id_transaksi' => $id);
    $tanggal = array('tanggal' => $tgl1);
    $data = $this->M_admin->report_data_barang_masuk($id,$tgl1);

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // document informasi
    $pdf->SetCreator('Web Aplikasi Gudang');
    $pdf->SetTitle('Laporan Data Barang Masuk');
    $pdf->SetSubject('Barang KelMasukuar');

    //header Data
    $pdf->SetHeaderData('logo.ico',30,'Laporan Data','Barang Masuk',array(203, 58, 44),array(0, 0, 0));
    $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margin
    $pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP + 10,PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

    //SET Scaling ImagickPixel
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //FONT Subsetting
    $pdf->setFontSubsetting(true);

    $pdf->SetFont('helvetica','',12,'',true);

    $pdf->AddPage('L');

    $html=
      '<div>
        <h1 align="center">Invoice Bukti Barang Masuk</h1><br>
        <p>No Id Transaksi  : '.$id.'</p>
        <p>Ditunjukan Untuk :</p>
        <p>Tanggal          : '.$tgl1.'</p>
        <p>Po.Customer      :</p>


        <table border="1">
          <tr>
            <th style="width:40px" align="center">No</th>
            <th style="width:110px" align="center">ID Transaksi</th>
            <th style="width:110px" align="center">Tanggal Masuk</th>
            <th style="width:130px" align="center">Lokasi</th>
            <th style="width:140px" align="center">Kode Barang</th>
            <th style="width:140px" align="center">Nama Barang</th>
            <th style="width:80px" align="center">Satuan</th>
            <th style="width:80px" align="center">Jumlah</th>
          </tr>';


          $no = 1;
          $JumlahSemua = 0;
          foreach($data as $d){
            $JumlahSemua += $d->jumlah;
            $html .= '<tr>';
            $html .= '<td align="center">'.$no.'</td>';
            $html .= '<td align="center">'.$d->id_transaksi.'</td>';
            $html .= '<td align="center">'.$d->tanggal.'</td>';
            $html .= '<td align="center">'.$d->lokasi.'</td>';
            $html .= '<td align="center">'.$d->id_barang.'</td>';
            $html .= '<td align="center">'.$d->nama_barang.'</td>';
            $html .= '<td align="center">'.$d->satuan.'</td>';
            $html .= '<td align="center">'.$d->jumlah.'</td>';
            $html .= '</tr>';
            $no++;
          }
            $html .= '<tr>';
            $html .= '<td align="center" colspan="7"><b>Jumlah</b></td>';
            $html .= '<td align="center">'.$JumlahSemua.'</td>';
            $html .= '</tr>';


        $html .='
            </table><br>
            <h6>Mengetahui</h6><br><br>
            <h6>Admin</h6>
          </div>';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

    $pdf->Output('invoice_barang_masuk.pdf','I');

  }

}




?>
