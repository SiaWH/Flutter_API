'use strict';
const MANIFEST = 'flutter-app-manifest';
const TEMP = 'flutter-temp-cache';
const CACHE_NAME = 'flutter-app-cache';

const RESOURCES = {"assets/AssetManifest.bin": "a32b44329c0bf073a1f5670068ee9110",
"assets/AssetManifest.bin.json": "b0d62b33b2c4f1db94d9020490d3616e",
"assets/AssetManifest.json": "8aab1b89f635801cc219fb30c2e7ffc9",
"assets/assets/abs.webp": "778ed833ee0626ff2ade88e71d4d4ca0",
"assets/assets/advanced.jpg": "1b053e17d4083cdb6e55195ad07b7989",
"assets/assets/Alternating-Dumbbell-Front-Raise.gif": "a08efe01b391549e1a0ec8f70d390d28",
"assets/assets/archer-push-up.gif": "78c0900a9566e4e4f6dab0ddddded11b",
"assets/assets/arm.jpeg": "f5c24c86769f67dcf87c0346d9763509",
"assets/assets/back.webp": "9acd05b8bd4590efe83cdd53a3dfe8c6",
"assets/assets/backhand-push-up.gif": "d7ba79ad0d8f5e3a127a2c1e7964bb64",
"assets/assets/Barbell-Bench-Press.gif": "e89b9e777389288abb4b73f354741de9",
"assets/assets/Barbell-Bent-Over-Row.gif": "4844e13bf8377667ae24144afc4124da",
"assets/assets/Barbell-Close-Grip-Bench-Press-Upper-Arms.gif": "04afceb6497422d304950c0475ad7829",
"assets/assets/barbell-full-squat.gif": "c3c6ba1cff7981af3e0dbc1792554963",
"assets/assets/beginner.jpg": "3772478eb5256339f8c3c791143ab233",
"assets/assets/bike-crunch.gif": "4e8602becec880ef9f063c0f35661185",
"assets/assets/bulgarian-split-spuat.webp": "2aa66240f54605977c6e45bfada36740",
"assets/assets/cable-crunch.gif": "95bd60a1885252e81d437a0402485cc6",
"assets/assets/cable-inner-chest-press.gif": "0d6635302efb3125a3ec32f0c1183b7f",
"assets/assets/Cable-Lateral-Raise.gif": "7214b4e9fd9a9ea7be05a798bf820d63",
"assets/assets/cable-seated-cross-arm-twist.gif": "ae7f4140462a3a60d2faea2f9ef8001a",
"assets/assets/captains-chair-leg-raise.gif": "8a1775465842b2d058e86facd1388c8a",
"assets/assets/carbs.png": "e26da3344f6153cab3082709fd59a196",
"assets/assets/chest.png": "7eb92799fed5a5b86520d770660042e7",
"assets/assets/chest.webp": "0439384cd29f8d7e8957c63872168313",
"assets/assets/christ_bumbstead.png": "d43ef5d85fc4413b57e8ce266f0a0885",
"assets/assets/Cross-Arm-Push-up.gif": "777dd08e699a139466de66fe5cea1aad",
"assets/assets/cross-cable-face-pull.gif": "067e78a8207f2e81b750db597a72442a",
"assets/assets/cross-oblique-crunch-exercise.gif": "bd41267e03d3da420a56c59fdd4b7653",
"assets/assets/deadlift.gif": "4312248b6aee11429329a6099a7170c3",
"assets/assets/Decline-Push-Up.gif": "ea0b7cf8fcbe26eb45cb17feeb27f815",
"assets/assets/Diamond-Push-up.gif": "b86e2baf2e17170f940b598d0386c475",
"assets/assets/DSBORDR.gif": "2d6925e633351cbf9b7789d5007648bc",
"assets/assets/Dumbbell-Chest-Press.gif": "561d51ba3a03164418a8cbb031662468",
"assets/assets/Dumbbell-Chest-Press.jpg": "1d3ef17a9c30de76e724f6d9f9417a1d",
"assets/assets/Dumbbell-Chest-Press.webp": "996a1449e883060a4a42ea6ff98f817b",
"assets/assets/Dumbbell-Flyes.gif": "530bd32f5a362ccf6acde6ee530ea92f",
"assets/assets/Dumbbell-Goblet-Squat.gif": "d62b9b4c947a59d8ee864f345ba9f5e4",
"assets/assets/Dumbbell-Kickback.gif": "96a1b68a9a9f4c853b695a3740e91326",
"assets/assets/Dumbbell-Lateral-Raise.gif": "3d05b59f45c6dae7a053b07d52befafb",
"assets/assets/dumbbell-lunges.gif": "043316b09e5be88544b7d005b7b7f494",
"assets/assets/Dumbbell-Shoulder-Press.gif": "bb1f03f0c87434b0fe4e327c7b40cfa4",
"assets/assets/dumbbell-single-arm-row.gif": "d79c0ec62a14f35b00c75ac97a4a59d4",
"assets/assets/expert.webp": "01c9fd0fb3c8ce5aac43a699c60ca3de",
"assets/assets/fats.png": "a6b27ab449c9ae4cf2e1a23fc2236c31",
"assets/assets/fibre.png": "fd0298a268dce2995945902a903888de",
"assets/assets/food.png": "7920fffbc1f8294ef647846e9ed35357",
"assets/assets/Hammer-Curl.gif": "5b678654fbfc266b08c32728d617d80c",
"assets/assets/hanging-abs-curl.gif": "797de11dacb57356d8ad24fb32233090",
"assets/assets/heel-raised-wall-sit.gif": "8a7a451c38d2465b6b188c4c2c2adbff",
"assets/assets/Incline-Dumbbell-Press.webp": "42e92d94603231c63951a9082b2ac80c",
"assets/assets/incline-push-up-bench.gif": "c7916d8754ef5639c5875a6df3c78432",
"assets/assets/inms_hannaoeberg.jpg": "922e22f846014bd0faf04d2847c18641",
"assets/assets/intermediate.webp": "9785b1fb8e9dd651029d1ca34cbb2342",
"assets/assets/inverted-row.gif": "768a184e25b4e8e02caa959eedb8c35a",
"assets/assets/Jess-Trainer-Image-scaled.webp": "56ae9fcd6d39ae292319c37a656e66df",
"assets/assets/kcal.png": "852c55e3bd668b6e1f6b70a5ce977f4d",
"assets/assets/knee-push-ups.gif": "aed14ffbf3db5ba84c197edc5105f7b7",
"assets/assets/Knee-Push-Ups.jpg": "8126cadb94408ac9a0f2d93cb6ee7f58",
"assets/assets/knee-touch-crunch.gif": "2d8d3cc6c191eaabe35cec3ef9e6637c",
"assets/assets/kneeling-diamond-push-ups.gif": "469cda6bae1d16616199b867b4ba7e37",
"assets/assets/kneeling-wide-push-ups.gif": "187b6b938703bd4f6d494a3a45b5f3eb",
"assets/assets/Lat-Pulldown.gif": "2f774d8db45e891762efac19b9aa99b8",
"assets/assets/lat-pushdown.gif": "f3c6c61555639c1bb1a4b2c9c2c799c8",
"assets/assets/leg-extension-machine.gif": "31148b09938497d38523d8f347635a08",
"assets/assets/leg-press.gif": "8790da234e4364db5309071ae79b0c05",
"assets/assets/leg-raise-crunches.gif": "4e1b854d14a3caf189e14917f961f96e",
"assets/assets/legs.webp": "203dfb771d53b4bc1e1f627600ecce78",
"assets/assets/lunges.gif": "2675ce2b1ae870032bc419ac41015e0b",
"assets/assets/master.webp": "383c72f0bc413dcd99c3df5c209ac05c",
"assets/assets/mike_o_hearn.webp": "d11b319856793ef514b88a889acc72bb",
"assets/assets/military-press.gif": "3b7103dc374dd5bad18f32ab2c356c70",
"assets/assets/muscle.jpg": "c22b723ab6ccfae527c7a77dec10863b",
"assets/assets/Overhead-Dumbbell-Extension.gif": "dcd680efde0ad3a4aace412abd7c4d71",
"assets/assets/parallel-bar-dip.gif": "9ddf7cc714f5bb8915b48095b2da88ec",
"assets/assets/pike-push-up.gif": "8f3d20de6cf612797ab112ad6e1913f9",
"assets/assets/place1.png": "ff15cf4224001c788994803facf0de6e",
"assets/assets/place2.png": "960802d3bc8e4ad49e3ef0842b3b4464",
"assets/assets/place3.png": "3648726094943103e05918936fc323bb",
"assets/assets/place4.png": "8acc4d28f25fffeb8a058b1162724a70",
"assets/assets/place5.png": "74cdddae18bc97e461728400dad7c4dc",
"assets/assets/Preacher-Curl.gif": "1249243000df5ddd2542df64755979cb",
"assets/assets/proteins.png": "1026a270c195284fac40302ce06a770c",
"assets/assets/pull-up.gif": "81ef29a252fb542bad4564613f432587",
"assets/assets/push-up.gif": "236a19e477aa92a6a22e9748b881ee73",
"assets/assets/push-up.jpg": "5318a35536a23756b05fbf92309ac06e",
"assets/assets/rate.png": "9d16f79864877eeaa34f0ca49e648577",
"assets/assets/rest.webp": "cfc5e4d6f88c8fe259c287d734b69055",
"assets/assets/ronnie_coleman.jpg": "5582eee083235df2daf21e4a788895cf",
"assets/assets/rope-bicep-curls.gif": "f4de39f83b9b2237dcab7f125d3a4fb1",
"assets/assets/Rope-Pushdown.gif": "a6f8518120f6f2860a8dc1a694c7f967",
"assets/assets/russian-twist-with-dumbbell.gif": "ba17a192b8c431d4befc59680e64fab6",
"assets/assets/Russian-Twist.gif": "fd216722627b23cef752623a57cf406b",
"assets/assets/seated-back-row.gif": "ac2b1f7260f0d0737c542100c5064522",
"assets/assets/seated-hammer-curl.gif": "022f5c31d0b02102f07d344e0ea69382",
"assets/assets/Seated-Incline-Dumbbell-Curl.gif": "44f27d73ab1ce1a72b09b6a8343d3ee6",
"assets/assets/seated-leg-curl.gif": "ac479adeeef63805c00e988393137ba4",
"assets/assets/shoulders.webp": "e4b4821600a97d45376ee107f9b1e9c1",
"assets/assets/sphinx-push-up.gif": "8af0b12a26aa40ce2e6073aeb5d697ae",
"assets/assets/squat.gif": "9bcc3db6d271d464a47ad0721fc8eaf3",
"assets/assets/Standing-Bicep-Curls-with-Dumbbells.gif": "5756187be58745fa29cc8679dcf205ed",
"assets/assets/Standing-Dumbbell-Overhead-Press.gif": "ba165e6eb896ed3108bde0f74bc4dc12",
"assets/assets/Step-up.gif": "96a0d4e25467944d6491ed1c7597b68f",
"assets/assets/success.json": "394a29335d1047fd4cc193884f887f66",
"assets/assets/superman.gif": "150b0ded259b93bacf5cb2fcb78504cd",
"assets/assets/thesia.png": "f69cfe28a5e92ee505b732a1efd9092e",
"assets/assets/Tricep-Dips.webp": "568678e44cd9faf9fbc99a23be667487",
"assets/assets/triceps.webp": "2888cc049969ef9d3c6e1ff881aa3689",
"assets/assets/tuck-crunch.gif": "978fc9e5bc3950ecd9561afeafe554fe",
"assets/assets/v-crunch.gif": "3d84de8a5b5d300b7f17ceeaa52d0163",
"assets/assets/water-bottle.png": "0d61c68579587314aa0b673f55fc5220",
"assets/assets/water.png": "66901cc5584aa0b8dbf4ce0340b79542",
"assets/assets/wide-push-ups.gif": "236a19e477aa92a6a22e9748b881ee73",
"assets/assets/yap_jy.png": "02280a04b2be21c328fcda7be62ecc89",
"assets/FontManifest.json": "dc3d03800ccca4601324923c0b1d6d57",
"assets/fonts/MaterialIcons-Regular.otf": "36a2a488b450b6e3730e6a0eb56c041e",
"assets/NOTICES": "c32f6d2378416be95e082b2c8b702f10",
"assets/packages/cupertino_icons/assets/CupertinoIcons.ttf": "89ed8f4e49bcdfc0b5bfc9b24591e347",
"assets/packages/flutter_inappwebview/assets/t_rex_runner/t-rex.css": "5a8d0222407e388155d7d1395a75d5b9",
"assets/packages/flutter_inappwebview/assets/t_rex_runner/t-rex.html": "16911fcc170c8af1c5457940bd0bf055",
"assets/packages/youtube_player_flutter/assets/speedometer.webp": "50448630e948b5b3998ae5a5d112622b",
"assets/shaders/ink_sparkle.frag": "4096b5150bac93c41cbc9b45276bd90f",
"canvaskit/canvaskit.js": "eb8797020acdbdf96a12fb0405582c1b",
"canvaskit/canvaskit.wasm": "64edb91684bdb3b879812ba2e48dd487",
"canvaskit/chromium/canvaskit.js": "0ae8bbcc58155679458a0f7a00f66873",
"canvaskit/chromium/canvaskit.wasm": "f87e541501c96012c252942b6b75d1ea",
"canvaskit/skwasm.js": "87063acf45c5e1ab9565dcf06b0c18b8",
"canvaskit/skwasm.wasm": "4124c42a73efa7eb886d3400a1ed7a06",
"canvaskit/skwasm.worker.js": "bfb704a6c714a75da9ef320991e88b03",
"favicon.png": "5dcef449791fa27946b3d35ad8803796",
"flutter.js": "59a12ab9d00ae8f8096fffc417b6e84f",
"icons/Icon-192.png": "ac9a721a12bbc803b44f645561ecb1e1",
"icons/Icon-512.png": "96e752610906ba2a93c65f8abe1645f1",
"icons/Icon-maskable-192.png": "c457ef57daa1d16f64b27b786ec2ea3c",
"icons/Icon-maskable-512.png": "301a7604d45b3e739efc881eb04896ea",
"index.html": "8632aef14408bd32b6de2de87ca5b283",
"/": "8632aef14408bd32b6de2de87ca5b283",
"main.dart.js": "a781cb0e8a932a05deb6e766a92965a1",
"manifest.json": "6141da04e5e89900003240af5e783e2f",
"version.json": "0807a48fa5e66275746318972a617050"};
// The application shell files that are downloaded before a service worker can
// start.
const CORE = ["main.dart.js",
"index.html",
"assets/AssetManifest.json",
"assets/FontManifest.json"];

// During install, the TEMP cache is populated with the application shell files.
self.addEventListener("install", (event) => {
  self.skipWaiting();
  return event.waitUntil(
    caches.open(TEMP).then((cache) => {
      return cache.addAll(
        CORE.map((value) => new Request(value, {'cache': 'reload'})));
    })
  );
});
// During activate, the cache is populated with the temp files downloaded in
// install. If this service worker is upgrading from one with a saved
// MANIFEST, then use this to retain unchanged resource files.
self.addEventListener("activate", function(event) {
  return event.waitUntil(async function() {
    try {
      var contentCache = await caches.open(CACHE_NAME);
      var tempCache = await caches.open(TEMP);
      var manifestCache = await caches.open(MANIFEST);
      var manifest = await manifestCache.match('manifest');
      // When there is no prior manifest, clear the entire cache.
      if (!manifest) {
        await caches.delete(CACHE_NAME);
        contentCache = await caches.open(CACHE_NAME);
        for (var request of await tempCache.keys()) {
          var response = await tempCache.match(request);
          await contentCache.put(request, response);
        }
        await caches.delete(TEMP);
        // Save the manifest to make future upgrades efficient.
        await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
        // Claim client to enable caching on first launch
        self.clients.claim();
        return;
      }
      var oldManifest = await manifest.json();
      var origin = self.location.origin;
      for (var request of await contentCache.keys()) {
        var key = request.url.substring(origin.length + 1);
        if (key == "") {
          key = "/";
        }
        // If a resource from the old manifest is not in the new cache, or if
        // the MD5 sum has changed, delete it. Otherwise the resource is left
        // in the cache and can be reused by the new service worker.
        if (!RESOURCES[key] || RESOURCES[key] != oldManifest[key]) {
          await contentCache.delete(request);
        }
      }
      // Populate the cache with the app shell TEMP files, potentially overwriting
      // cache files preserved above.
      for (var request of await tempCache.keys()) {
        var response = await tempCache.match(request);
        await contentCache.put(request, response);
      }
      await caches.delete(TEMP);
      // Save the manifest to make future upgrades efficient.
      await manifestCache.put('manifest', new Response(JSON.stringify(RESOURCES)));
      // Claim client to enable caching on first launch
      self.clients.claim();
      return;
    } catch (err) {
      // On an unhandled exception the state of the cache cannot be guaranteed.
      console.error('Failed to upgrade service worker: ' + err);
      await caches.delete(CACHE_NAME);
      await caches.delete(TEMP);
      await caches.delete(MANIFEST);
    }
  }());
});
// The fetch handler redirects requests for RESOURCE files to the service
// worker cache.
self.addEventListener("fetch", (event) => {
  if (event.request.method !== 'GET') {
    return;
  }
  var origin = self.location.origin;
  var key = event.request.url.substring(origin.length + 1);
  // Redirect URLs to the index.html
  if (key.indexOf('?v=') != -1) {
    key = key.split('?v=')[0];
  }
  if (event.request.url == origin || event.request.url.startsWith(origin + '/#') || key == '') {
    key = '/';
  }
  // If the URL is not the RESOURCE list then return to signal that the
  // browser should take over.
  if (!RESOURCES[key]) {
    return;
  }
  // If the URL is the index.html, perform an online-first request.
  if (key == '/') {
    return onlineFirst(event);
  }
  event.respondWith(caches.open(CACHE_NAME)
    .then((cache) =>  {
      return cache.match(event.request).then((response) => {
        // Either respond with the cached resource, or perform a fetch and
        // lazily populate the cache only if the resource was successfully fetched.
        return response || fetch(event.request).then((response) => {
          if (response && Boolean(response.ok)) {
            cache.put(event.request, response.clone());
          }
          return response;
        });
      })
    })
  );
});
self.addEventListener('message', (event) => {
  // SkipWaiting can be used to immediately activate a waiting service worker.
  // This will also require a page refresh triggered by the main worker.
  if (event.data === 'skipWaiting') {
    self.skipWaiting();
    return;
  }
  if (event.data === 'downloadOffline') {
    downloadOffline();
    return;
  }
});
// Download offline will check the RESOURCES for all files not in the cache
// and populate them.
async function downloadOffline() {
  var resources = [];
  var contentCache = await caches.open(CACHE_NAME);
  var currentContent = {};
  for (var request of await contentCache.keys()) {
    var key = request.url.substring(origin.length + 1);
    if (key == "") {
      key = "/";
    }
    currentContent[key] = true;
  }
  for (var resourceKey of Object.keys(RESOURCES)) {
    if (!currentContent[resourceKey]) {
      resources.push(resourceKey);
    }
  }
  return contentCache.addAll(resources);
}
// Attempt to download the resource online before falling back to
// the offline cache.
function onlineFirst(event) {
  return event.respondWith(
    fetch(event.request).then((response) => {
      return caches.open(CACHE_NAME).then((cache) => {
        cache.put(event.request, response.clone());
        return response;
      });
    }).catch((error) => {
      return caches.open(CACHE_NAME).then((cache) => {
        return cache.match(event.request).then((response) => {
          if (response != null) {
            return response;
          }
          throw error;
        });
      });
    })
  );
}
