<style>
.load-wrapp {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: -webkit-flex;
  display: -moz-flex;
  display: -ms-flex;
  display: -o-flex;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-align-items: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  z-index: 1051; }
  
  .line {
  display: inline-block;
  width: 15px;
  height: 15px;
  border-radius: 15px;
  background-color: #fff; }

.load-3 .line:nth-last-child(1) {
  -webkit-animation: loadingC .6s .1s linear infinite;
  animation: loadingC .6s .1s linear infinite; }

.load-3 .line:nth-last-child(2) {
  -webkit-animation: loadingC .6s .2s linear infinite;
  animation: loadingC .6s .2s linear infinite; }

.load-3 .line:nth-last-child(3) {
  -webkit-animation: loadingC .6s .3s linear infinite;
  animation: loadingC .6s .3s linear infinite; }

.l-1 {
  -webkit-animation-delay: .48s;
  animation-delay: .48s; }

.l-2 {
  -webkit-animation-delay: .6s;
  animation-delay: .6s; }

.l-3 {
  -webkit-animation-delay: .72s;
  animation-delay: .72s; }

.l-4 {
  -webkit-animation-delay: .84s;
  animation-delay: .84s; }

.l-5 {
  -webkit-animation-delay: .96s;
  animation-delay: .96s; }

.l-6 {
  -webkit-animation-delay: 1.08s;
  animation-delay: 1.08s; }

.l-7 {
  -webkit-animation-delay: 1.2s;
  animation-delay: 1.2s; }

.l-8 {
  -webkit-animation-delay: 1.32s;
  animation-delay: 1.32s; }

.l-9 {
  -webkit-animation-delay: 1.44s;
  animation-delay: 1.44s; }

.l-10 {
  -webkit-animation-delay: 1.56s;
  animation-delay: 1.56s; }

@-webkit-keyframes loadingC {
  0 {
    -webkit-transform: translate(0, 0);
    transform: translate(0, 0); }
  50% {
    -webkit-transform: translate(0, 15px);
    transform: translate(0, 15px); }
  100% {
    -webkit-transform: translate(0, 0);
    transform: translate(0, 0); } }

@keyframes loadingC {
  0 {
    -webkit-transform: translate(0, 0);
    transform: translate(0, 0); }
  50% {
    -webkit-transform: translate(0, 15px);
    transform: translate(0, 15px); }
  100% {
    -webkit-transform: translate(0, 0);
    transform: translate(0, 0); } }
</style>

<div class="load-wrapp" style="display: none;">
  <div class="load-3">
    <div class="line"></div>
    <div class="line"></div>
    <div class="line"></div>
  </div>
</div>