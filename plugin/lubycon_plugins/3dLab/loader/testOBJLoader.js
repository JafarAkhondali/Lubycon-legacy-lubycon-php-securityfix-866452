/**
 * @author mrdoob / http://mrdoob.com/
 */

THREE.OBJLoader = function ( manager ) {

	this.manager = ( manager !== undefined ) ? manager : THREE.DefaultLoadingManager;

	this.materials = null;

};

THREE.OBJLoader.prototype = {

	constructor: THREE.OBJLoader,

	load: function ( url, onLoad, onProgress, onError ) {

		var scope = this;

		var loader = new THREE.XHRLoader( scope.manager );
		loader.setPath( this.path );
		loader.load( url, function ( text ) {

			onLoad( scope.parse( text ) );

		}, onProgress, onError );

	},

	setPath: function ( value ) {

		this.path = value;

	},

	setMaterials: function ( materials ) {

		this.materials = materials;

	},

	parse: function ( text ) { //text = file contents
		"use strict";

		console.time( 'OBJLoader' );
		var objects = [];
		var object = {
			geometry: new THREE.Geometry(),
			material: [],
			name: null
		}
		var vertices = [];
		var normals = [];
		var uvs = [];
		var faceVertexUV = [];
		var faces = [];

		var patterns;

		var vertexCount = 0;
		var normalCount = 0;
		var uvCount = 0;
		var triFaceCount = 0;
		var quadFaceCount = 0;
		var materialCount = 0;

		function addVertex(x,y,z){
			var vertex = new THREE.Vector3(x,y,z);
			vertices.push(vertex);
			object.geometry.vertices = vertices;
			object.geometry.verticesNeedUpdate = true;
		}
		function addNormal(x,y,z){
			var normal = new THREE.Vector3(x,y,z);
			normals.push(normal);
		}
		function addUV(w,h){
			var uv = new THREE.Vector2(w,h);
			uvs.push(uv);
		}
		function addFace(v1,v2,v3,v4,uv1,uv2,uv3,uv4,nm1,nm2,nm3,nm4){
			var face = new THREE.Face3(1,1,1);
			var face2 = new THREE.Face3(1,1,1);
			var uvArray = [];
			var uvArray2 = [];

			if(isNaN(v4)){
				triFaceCount++;
				face.a = v1;
				face.b = v2;
				face.c = v3;
				face.materialIndex = (object.material.length) - 1;
			}
			else{
				quadFaceCount++;
				face.a = v1;
				face.b = v2;
				face.c = v4;
				face2.a = v2;
				face2.b = v3;
				face2.c = v4;

				face.materialIndex = (object.material.length) - 1;
				face2.materialIndex = (object.material.length) - 1;
			}
			if(!isNaN(uv1)){ //face uv = [x,y,z]
				if(!isNaN(uv4)){
					var a = uvs[uv1];
					var b = uvs[uv2];
					var c = uvs[uv3];
					var d = uvs[uv4];
					uvArray.push(a,b,d);
					uvArray2.push(b,c,d);
				}
				else if(isNaN(uv4)){
					var a = uvs[uv1];
					var b = uvs[uv2];
					var c = uvs[uv3];
					uvArray.push(a,b,c);
				}
			}

			if(!isNaN(nm1)){
				if(!isNaN(nm4)){
					var a = normals[nm1];
					var b = normals[nm2];
					var c = normals[nm3];
					var d = normals[nm4];
					face.normal.set(a,b,d);
					face2.normal.set(b,c,d);
				}
				else if(isNaN(nm4)){
					var a = normals[nm1];
					var b = normals[nm2];
					var c = normals[nm3];
					face.normal.set(a,b,c);
				}
			}
			
			if(isNaN(v4)) faces.push(face);
			else faces.push(face,face2);

			if(isNaN(uv4)) faceVertexUV.push(uvArray);
			else faceVertexUV.push(uvArray,uvArray2);
		}

		////////////////////////////////////////patterns start/////////////////////////////////////
		patterns = {
			vertex : /^v\s+([\d|\.|\+|\-|e|E]+)\s+([\d|\.|\+|\-|e|E]+)\s+([\d|\.|\+|\-|e|E]+)/,
			//v float float float
			normal : /^vn\s+([\d|\.|\+|\-|e|E]+)\s+([\d|\.|\+|\-|e|E]+)\s+([\d|\.|\+|\-|e|E]+)/,
			//vn float float float
			uv : /^vt\s+([\d|\.|\+|\-|e|E]+)\s+([\d|\.|\+|\-|e|E]+)/,
			//vt float float
			face1 : /^f\s+(-?\d+)\s+(-?\d+)\s+(-?\d+)(?:\s+(-?\d+))?/,
			//f vertex vertex vertex (index)
			face2 : /^f\s+((-?\d+)\/(-?\d+))\s+((-?\d+)\/(-?\d+))\s+((-?\d+)\/(-?\d+))(?:\s+((-?\d+)\/(-?\d+)))?/,
			//f vertex/uv vertex/uv vertex/uv (index)
			face3 : /^f\s+((-?\d+)\/(-?\d+)\/(-?\d+))\s+((-?\d+)\/(-?\d+)\/(-?\d+))\s+((-?\d+)\/(-?\d+)\/(-?\d+))(?:\s+((-?\d+)\/(-?\d+)\/(-?\d+)))?/,
			//f vertex/uv/normal vertex/uv/normal vertex/uv/normal
			face4 : /^f\s+((-?\d+)\/\/(-?\d+))\s+((-?\d+)\/\/(-?\d+))\s+((-?\d+)\/\/(-?\d+))(?:\s+((-?\d+)\/\/(-?\d+)))?/,
			//f vertex//normal vertex//normal vertex//normal
			object : /^[og]\s*(.+)?/,
			smooth : /^s\s+(\d+|on|off)/,
			mtllib : /^mtllib /,
			usemtl : /^usemtl /
		};
		//////////////////////////////////////////patterns end////////////////////////////////////
		var lines = text.split("\n"),
		result;
		for(var i = 0, l = lines.length; i < l; i++){
			var line = lines[i];
			line = line.trim();
			if(line.length === 0 || line.charAt(0) === "#"){
				continue;
			}
			else if((result = patterns.vertex.exec(line)) !== null){
				var x = parseFloat(result[1]);
				var y = parseFloat(result[2]);
				var z = parseFloat(result[3]);
				vertexCount++;
				addVertex(x,y,z);
				//console.log("vertex_" + vertexCount + " : " + result[1],result[2],result[3]);
			}
			else if((result = patterns.normal.exec(line)) !== null){
				var x = parseFloat(result[1]);
				var y = parseFloat(result[2]);
				var z = parseFloat(result[3]);
				normalCount++;
				addNormal(x,y,z);
				//console.log("normal_" + normalCount + " : " + result[1],result[2],result[3]);
			}
			else if((result = patterns.uv.exec(line)) !== null){
				var w = parseFloat(result[1]);
				var h = parseFloat(result[2]);
				uvCount++;
				addUV(w,h);
				//console.log("uv_" + uvCount + " : " + result[1],result[2]);
			}
			else if((result = patterns.face1.exec(line)) !== null){
				//console.log(result);
				var v1 = parseFloat(result[1]) - 1;
				var v2 = parseFloat(result[2]) - 1;
				var v3 = parseFloat(result[3]) - 1;
				var v4 = parseFloat(result[4]) - 1;
				addFace(v1,v2,v3,v4);
			}
			else if((result = patterns.face2.exec(line)) !== null){
				var v1 = parseFloat(result[2]) - 1;
				var v2 = parseFloat(result[5]) - 1;
				var v3 = parseFloat(result[8]) - 1;
				var v4 = parseFloat(result[11]) - 1;

				var uv1 = parseFloat(result[3]) - 1;
				var uv2 = parseFloat(result[6]) - 1;
				var uv3 = parseFloat(result[9]) - 1;
				var uv4 = parseFloat(result[12]) - 1;

				addFace(v1,v2,v3,v4,uv1,uv2,uv3,uv4);
				//console.log("face");
			}
			else if((result = patterns.face3.exec(line)) !== null){
				var v1 = parseFloat(result[2]) - 1;
				var v2 = parseFloat(result[6]) - 1;
				var v3 = parseFloat(result[10]) - 1;
				var v4 = parseFloat(result[14]) - 1;

				var uv1 = parseFloat(result[3]) - 1;
				var uv2 = parseFloat(result[7]) - 1;
				var uv3 = parseFloat(result[11]) - 1;
				var uv4 = parseFloat(result[15]) - 1;

				var nm1 = parseFloat(result[4]) - 1;
				var nm2 = parseFloat(result[8]) - 1;
				var nm3 = parseFloat(result[12]) - 1;
				var nm4 = parseFloat(result[16]) - 1;
				addFace(v1,v2,v3,v4,uv1,uv2,uv3,uv4,nm1,nm2,nm3,nm4);
			}
			else if((result = patterns.face4.exec(line)) !== null){
				var v1 = parseFloat(result[2]) - 1;
				var v2 = parseFloat(result[5]) - 1;
				var v3 = parseFloat(result[8]) - 1;
				var v4 = parseFloat(result[11]) - 1;

				var uv1 = undefined;
				var uv2 = undefined;
				var uv3 = undefined;
				var uv4 = undefined;

				var nm1 = parseFloat(result[3]) - 1;
				var nm2 = parseFloat(result[6]) - 1;
				var nm3 = parseFloat(result[9]) - 1;
				var nm4 = parseFloat(result[12]) - 1;
				addFace(v1,v2,v3,v4,uv1,uv2,uv3,uv4,nm1,nm2,nm3,nm4);
			}
			else if((result = patterns.object.exec(line)) !== null){
				console.log("object/group");
			}
			else if((result = patterns.smooth.exec(line)) !== null){
				console.log("smooth : " + line.substring(2));
			}
			else if((result = patterns.mtllib.exec(line)) !== null){
				console.log("material library " + line.substring(7).trim());
			}
			else if((result = patterns.usemtl.exec(line)) !== null){
				var material = new THREE.MeshPhongMaterial({ color: 0x888888});
				material.name = line.substring(7).trim();

				object.material.push(material);

				materialCount++;
				console.log("material_" + materialCount + " : " + line.substring(7).trim());
			}
			else{
				$.error("Load Error : " + line);
			}
		}

		console.timeEnd( 'OBJLoader' );

		var multiMaterial = new THREE.MeshFaceMaterial(object.material);
		object.name = object.material[0];
		object.material = multiMaterial;


		object.geometry.vertices = vertices;
		object.geometry.faces = faces;
		object.geometry.faceVertexUvs[0] = faceVertexUV;
		object.geometry.elementsNeedUpdate = true;
		object.geometry.computeFaceNormals();
		//object.geometry.computeVertexNormals();

		console.log(object);
		console.log("vertices : " + vertexCount);
		console.log("normals : " + normalCount);
		console.log("uvs : " + uvCount);
		console.log("triFace : " + triFaceCount);
		console.log("quadFace : " + quadFaceCount);
		console.log("materials : " + materialCount);

		return object;
	}

};
