from flask import Flask, request
from flask import Response
from PIL import Image, ImageDraw, ImageFont
import os
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

@app.route('/labelimage')
def labelimage():
	
	pname = request.args.get('pname')
	imlink = request.args.get('imlink')

	text="www.memelok.com/page/"+pname
	image = Image.open('../main/data/post_img/'+imlink)
	W, H = image.size

	draw = ImageDraw.Draw(image)
	font = ImageFont.truetype('../main/static-assets/fonts/Roboto-Bold.ttf', 22)
	w, h = draw.textsize(text, font=font)

	rw = (W-w)/2
	rh = (H-h)/2

	draw.text(xy=(rw, rh), text=text, font=font, fill=(0, 0, 0), align="right")

	image.save("../main/data/img_watermarked/"+imlink)
	
	return Response(headers={'Access-Control-Allow-Origin':'*'}, response=imlink)


@app.route('/optimizememe')
def optimizeimage():
	imlink = request.args.get('imlink')
	imbig = request.args.get('imbig')
	imsmall = request.args.get('imsmall')

	img = Image.open('../main/data/post_img/'+imlink)
	W, H = img.size

	# for big --------

	ratio = W/500
	w_big = 500
	h_big = round(H/ratio)

	# - --------------

	# for small ------

	ratio = W/400
	w_small = 400
	h_small = round(H/ratio)

	# ----------------

	img_big = img.resize((w_big, h_big), Image.ANTIALIAS)
	img_big.save("../main/data/post_img/"+imbig)

	img_small = img.resize((w_small, h_small), Image.ANTIALIAS)
	img_small.save("../main/data/post_img/"+imsmall)	

	return Response(headers={'Access-Control-Allow-Origin':'*'}, response="optimize")

@app.route('/optimize-userdp')
def optimize_userdp():
	imlink = request.args.get('imlink')
	rname = request.args.get('rname')

	img = Image.open('../main/data/img_users/'+imlink)
	W, H = img.size

	# for big --------

	ratio = W/140
	w = 140
	h = round(H/ratio)

	img = img.resize((w,h), Image.ANTIALIAS)
	img.save("../main/data/img_users/"+rname)

	os.remove("../main/data/img_users/"+imlink)

	return Response(headers={'Access-Control-Allow-Origin':'*'}, response="optimize")


@app.route('/optimize-pagedp')
def optimize_pagedp():
	imlink = request.args.get('imlink')
	rname = request.args.get('rname')

	img = Image.open('../main/data/img_pages/'+imlink)
	W, H = img.size

	# for big --------

	ratio = W/140
	w = 140
	h = round(H/ratio)

	img = img.resize((w,h), Image.ANTIALIAS)
	img.save("../main/data/img_pages/"+rname)

	os.remove("../main/data/img_pages/"+imlink)

	return Response(headers={'Access-Control-Allow-Origin':'*'}, response="optimize")

app.run(debug=True, port=5000)