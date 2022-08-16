<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Barang Masuk</title>
</head>
<style>
</style>

<body>
  @php
  function tgl_indo($tanggal)
  {
  $bulan = array(
  1 => 'Januari',
  'Februari',
  'Maret',
  'April',
  'Mei',
  'Juni',
  'Juli',
  'Agustus',
  'September',
  'Oktober',
  'November',
  'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun

  return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
  }

  @endphp
  <table>
    <thead>
      <tr>
        <td style="border:hidden; text-align: left; font-weight: bold;" colspan="8">
          <img src="img/logo.png" alt="" width="40px" height="40px">
        </td>
      </tr>
      <tr>
        <td style="text-align: center; font-weight: bold; display: flex; " colspan="8">
          <h1 style="align-items: center">CV. Sukses Karya Abadi</h1>
        </td>
      </tr>
      <tr>
        <td style="text-align: center; border-bottom: 1px solid #000000; font-weight: bold;" colspan="8">Data
          Barang Masuk</td>
      </tr>
      <tr>
        <td style=" text-align: right;" colspan="8">{{ tgl_indo(date($tgl_awal)) .' - '.tgl_indo(date($tgl_akhir)) }}
        </td>
      </tr>

      <tr>
        <td style="height: 30px;" colspan="8"></td>
      </tr>
      <tr>
        <th scope="row"
          style="text-align:center; font-weight: bold; width: 30px; border: 1px solid #000000; line-height: 50%">
          #
        </th>
        <th scope="row" style="font-weight: bold; text-align: center; width: 110px; border: 1px solid #000000;">Kode
          Inventaris</th>
        <th scope="row" style="font-weight: bold; text-align: center; width: 110px; border: 1px solid #000000">Jenis
          Barang</th>
        <th scope="row" style="font-weight: bold; text-align: center; width: 130px; border: 1px solid #000000">Nama
          Barang</th>
        <th scope="row" style="font-weight: bold; text-align: center; width: 70px; border: 1px solid #000000">Barang
          Masuk</th>
        <th scope="row" style="font-weight: bold; text-align: center; width: 70px; border: 1px solid #000000">Sisa Stok
        </th>
        <th scope="row" style="font-weight: bold; text-align: center; width: 130px; border: 1px solid #000000">Tanggal
          Masuk</th>
        <th scope="row"
          style="font-weight: bold; text-align: center; width: 110px; border: 1px solid #000000; line-height: 50%">
          Petugas
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($BarangMasuk as $BM)
      <tr>
        <td style="border: 1px solid #000000; text-align: center;">{{ $loop->iteration }}</td>
        <td style="border: 1px solid #000000; text-align: center;">{{ $BM->Inven->k_inven }}</td>
        <td style="border: 1px solid #000000; text-align: center;">{{ $BM->jenbar }}</td>
        <td style="border: 1px solid #000000; text-align: center;">{{ $BM->nambar }}</td>
        <td style="border: 1px solid #000000; text-align: center;">{{ $BM->jumlah_masuk }}</td>
        <td style="border: 1px solid #000000; text-align: center;">{{ $BM->Inven->jumlah }}</td>
        <td style="border: 1px solid #000000; text-align: center;">{{ tgl_indo(date($BM->tgl_masuk)) }}</td>
        <td style="border: 1px solid #000000; text-align: center;">{{ $BM->User->nama }}</td>
      </tr>
      @endforeach
      <tr>
        <td style="text-align: center; margin-top: 20px; height: 30px;" colspan="4">Kepala Gudang</td>
        <td style="text-align: center; margin-top: 20px; height: 30px;" colspan="4">Manager</td>
      </tr>

      <tr>
        <td style="text-align: center; height: 80px; font-weight: bold;" colspan="4">{{ $kegud }}</td>
        <td style="text-align: center; height: 80px; font-weight: bold;" colspan="4">{{ $manager }}</td>
      </tr>
  </table>
</body>

</html>