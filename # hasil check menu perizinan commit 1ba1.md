# hasil check menu perizinan commit 1ba1275

1. /perizinan, (Staf, Kadiv, PPK, BOD, Admin) melakukan pegajuan perizinan ❌
    - menampilkan error jika ada field yang tidak diisi kecuali file ✅
    - berhasil menyimpan ke database ✅
    - memberikan error jika jumlah hari kurang dari nol(0) ❌
    - memberikan error jika jatah cuti tidak mencukupi ❌
    - tidak mengurangi jatah cuti Staf ✅
2. /perizinan, (Staf, Kadiv, PPK, BOD, Admin) melakukan update pegajuan perizinan ❌
    - mengosongkan perestujuan atasan dan PPK jika data diubah ✅
    - menampilkan error jika ada field yang tidak diisi kecuali file ✅
    - berhasil mengupdate ke database ✅
    - memberikan error jika jumlah hari kurang dari nol(0) ❌
    - memberikan error jika jatah cuti tidak mencukupi ❌
    - tidak mengurangi jatah cuti Staf ✅
3. /perizinan, (Staf, Kadiv, PPK, BOD, Admin) melakukan delete pegajuan perizinan, ✅
    - berhasil mengupdate ke database ✅
    - tidak mengurangi jatah cuti Staf ✅
4. /ajuanperizinan (Staf, Kadiv, PPK, BOD, Admin)
    - jika atasan dan PPK menyetujui, mengurangi jumlah jatah cuti pengaju ✅
    - mengurangi jatah cuti sesuai dengan jumlah hari perizinan ✅

-   validasi kalau cuti tahunan
-   check edit,delete
-   lock perizinan
-   share
-   notif
