<!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('assets/js/sb-admin-2.min.js')?>"></script>

    <!-- Page level plugins -->
    <script src="<?php echo base_url('assets/vendor/chart.js/Chart.min.js')?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo base_url('assets/js/demo/chart-area-demo.js')?>"></script>
    <script src="<?php echo base_url('assets/js/demo/chart-pie-demo.js')?>"></script>

    <!-- Page level plugins -->
    <script src="<?php echo base_url('assets/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo base_url('assets/js/demo/datatables-demo.js')?>"></script>

    <!-- Script untuk menambah barang detail -->
    <script type="text/javascript">
    
    </script>
    <!-- 
        SCRIPT UNTUK DATATABLES DI MODAL SAAT MILIH BARANG
        ketika button pilih barang di klik maka akan muncul pop up modal lalu kita klik lagi select pada data yang ingin kita
        pilih setelah itu value dari table akan di parsing ke formn input
     -->

     <script type='text/javascript'>
      let i = 0;
      function AddBarangDetail(){
        i++;
        $('#AddBarangDetail').append(`
              <tr id="`+i+`">
              <td><input type="text" name="kode_barang[]" id="kode_barang`+i+`" readonly class="form-control" placeholder="Kode Barang" required></td>
              <td><textarea name="nama_barang[]" id="nama_Barang`+i+`" readonly class="form-control" placeholder="Nama Barang" required></textarea></td>
              <td><select class="form-control" name="satuan[]" id="satuan`+i+`" required>
              <option value="" selected="">Pilih</option>
              <?php foreach($list_satuan as $s){ ?>
              <option value="<?=$s->kode_satuan?>"><?=$s->nama_satuan?></option>
              <?php } ?>
              </select></td>
              <td><input type="number" required name="jumlah[]" id="kode_barang" class="form-control" placeholder="Jumlah"></td>
              <td><a type="button" class="btn btn-danger btn-delete" href="#" onclick="hapus(`+i+`)" name="btn_delete"><i class="fa fa-trash" aria-hidden="true"></i>Hapus</a></td>
              </tr>
        `);
      }
    
      function GetDataBarang() {

      // var tableDataDetail = document.getElementById('TambahBarang');
      var tableDataDetail = document.getElementById('TambahBarang'),
      rows = tableDataDetail.rows, rowcount = rows.length, r,
      cells, cellcount, c, cell;
      var table = document.getElementById('dataTable');

      var links = table.getElementsByTagName('a');
      for(var x = 0; x < links.length; x++) {
          links[x].onclick = function() {
            var parentCell = this.parentNode;
            var parentRow = parentCell.parentNode;

            var CodeBarangCell = parentRow.cells[parentCell.cellIndex-5]
            var NamaBarangCell = parentRow.cells[parentCell.cellIndex-4]
            var SatuanBarangCell = parentRow.cells[parentCell.cellIndex-3]
            var JumlahBarangCell = parentRow.cells[parentCell.cellIndex-2]

            var IDBarang = CodeBarangCell.textContent;
            var NamaBarang = NamaBarangCell.textContent;
            var SatuanBarang = SatuanBarangCell.textContent;
            var JumlahBarang = JumlahBarangCell.textContent;


            document.getElementById('kode_barang'+i).value = IDBarang;
            document.getElementById('nama_Barang'+i).value = NamaBarang;
            document.getElementById('satuan'+i).value = SatuanBarang;
          }
        }
      }
      window.onload = GetDataBarang();

    function hapus(index){
		  $('#'+index).remove();
	  }

  </script>
