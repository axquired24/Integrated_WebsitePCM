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

- Inisialisasi semua data (db) tiap aum saat CREATE
	- Menu (Home, Login)
	- Kategori Artikel (Pengumuman, Berita)
	- Kustom Halaman (Profil)
	- AUM (Map Lat,Lng) : Default di PCM KTS

- Untuk semua autocomplete kategori (galeri, pages, artikel) mengambil id saat login, aum_list_id
- halaman kontributor sendiri, dia login dari mana dapet id_nya > buat artikel berdasarkan aum_list_id
- users.aum_list_id : default 1: uncategorized AUM
- resize artikel gambar biar sama semua x * x
- keluarin directPost di semua sub situs pake Where tags='direct' OR where('category' in 'array_category')

#### Development Note
- Available stack = jscode, csscode, metacode
- Tag for broadcast = 'direct'
- Children for Menu = 1 / ''
- !IMPORTANT - PCM - AUM_LIST_ID = 1;

#### BUG
- Kekurangan Sistem
	- Image Upload @article & page : Limit Size & Resolution
- Cek :
	Link Detail @list artikel & halaman kustom belum link preview ke halaman depan
// Admin
-  Belum Buat pengumuman manajemen : Nanti di depan pilih kategori berapa yang pengumuman. Auto buat kategori pengumuman di pengumuman controller  / sama kayak article controller. post direct ke kategori pengumuman.
- @Article : Tambahi where kategori != ArticleCategory::where('nama','pengumuman');
- Error Petik ('/") di semua crud
- FileUpload : Limit @php.ini harus ditambahin
- Article : kudunya dikasih where(! tag='direct')
- Peletakan Menu :  - Add (Belum ditambahin fitur auto link halaman)
					- Add, Edit, Hapus : Belum auto reOrder


### BUG Fixed
- Tambah Artikel & Halaman
	@validation : unique:articles - tambahi where aum_id / kategori nya berapa gitu // Cukup pake id - gausah seo - slug

#### Testing
- Image Upload size Limit

### Other
- Menu
id - aum_list_id - name - link - parent - children
1  - 1 			- Home
2
3
4
5
6
