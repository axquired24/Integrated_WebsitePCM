#### REQUEST
- PCM Bisa Broadcast ke semua AUM
- Ada kontributor artikel
- Bisa ganti2 header tiap AUM
- 

#### DEVELOPER PLAN
- Buat folder files
	- artikel
		- aum_id
	- galeri
		- aum_id
	- halaman
		- aum_id
	- lain // buat file
		- aum_id
	- namaGambar : filename & thumb-filename
	- iconsize
		- article & halaman 100 * 100
		- galleri 300 * 300

- Untuk semua autocomplete kategori (galeri, pages, artikel) mengambil id saat login, aum_list_id
- halaman kontributor sendiri, dia login dari mana dapet id_nya > buat artikel berdasarkan aum_list_id
- users.aum_list_id : default 1: uncategorized AUM
- resize artikel gambar biar sama semua x * x

#### Development Note
- Available stack = jscode, csscode, metacode

#### BUG
- Kekurangan Sistem
	- Image Upload @article & page : Limit Size & Resolution
- Cek :
	Link Detail @list artikel & halaman kustom belum link preview ke halaman depan
-  Belum Buat pengumuman manajemen : Nanti di depan pilih kategori berapa yang pengumuman. Auto buat kategori pengumuman di pengumuman controller  / sama kayak article controller. post direct ke kategori pengumuman.
- @Article : Tambahi where kategori != ArticleCategory::where('nama','pengumuman');

### BUG Fixed
- Tambah Artikel & Halaman
	@validation : unique:articles - tambahi where aum_id / kategori nya berapa gitu // Cukup pake id - gausah seo - slug

#### Testing
- Image Upload size Limit