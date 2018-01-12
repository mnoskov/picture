Сниппет для формирования разных вариантов изображения под разные разрешения экрана и их вывода с использованием тега &lt;picture&gt;

Пример использования для сетки Bootstrap 4:

```
[[picture? &source=`assets/images/image.jpg` &phpthumboptions=`zc=1,f=jpg` &data=`[
	{
		"media": ">1200",
		"width": 1200,
		"height": 600,
		"alt": "test",
		"fallback": true
	}, {
		"media": ">992",
		"width": 1000
	}, {
		"media": ">768",
		"width": 800
	}, {
		"media": ">577",
		"width": 600
	}, {
		"media": "<577",
		"width": 400
	}
]`]]
```

На выходе получится это:
```
<picture>
	<source srcset="assets/cache/images/img-xl-1200x600-4fd.jpg 1x, assets/cache/images/img-xl-2400x1200-26a.jpg 2x" media="(min-width: 1200px)">
	<source srcset="assets/cache/images/img-xl-1000x500-f54.jpg 1x, assets/cache/images/img-xl-2000x1000-b7b.jpg 2x" media="(min-width: 992px)">
	<source srcset="assets/cache/images/img-xl-800x400-e37.jpg 1x, assets/cache/images/img-xl-1600x800-581.jpg 2x" media="(min-width: 768px)">
	<source srcset="assets/cache/images/img-xl-600x300-f1e.jpg 1x, assets/cache/images/img-xl-1200x600-4fd.jpg 2x" media="(min-width: 577px)">
	<source srcset="assets/cache/images/img-xl-400x200-963.jpg 1x, assets/cache/images/img-xl-800x400-eef.jpg 2x" media="(max-width: 576px)">
	<img src="assets/cache/images/img-xl-1200x600-4fd.jpg" srcset="assets/cache/images/img-xl-1200x600-4fd.jpg 1x, assets/cache/images/img-xl-2400x1200-26a.jpg 2x" alt="test" class="img-fluid">
</picture>
```
