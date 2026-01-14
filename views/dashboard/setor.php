<form action="../../controllers/SetorController.php" method="POST" enctype="multipart/form-data">

  <label>Jenis Sampah</label>
  <select name="jenis_sampah" required>
    <option value="">-- Pilih Jenis Sampah --</option>
    <option value="Plastik">Plastik</option>
    <option value="Kertas">Kertas</option>
    <option value="Logam">Logam</option>
    <option value="Organik">Organik</option>
  </select>

  <label>Berat Sampah (Kg)</label>
  <input type="number" step="0.1" name="berat" placeholder="Contoh: 3.5" required>

  <label>Upload Foto Sampah</label>
  <input type="file" name="foto" accept="image/*" required>

  <button type="submit" name="jemput">Jemput Sampah</button>
</form>
