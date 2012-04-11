// Флаг, создано ли поле
var isSeaBattleMake = false;


$(document).ready( function()
{
	$('#create_field_controls #make_field').click( function()
	{
		try
		{
			isSeaBattleMake = false;
			seaField.makeField();
			isSeaBattleMake = true;
		}
		catch( ex )
		{
			console.error( ex );
		}
		return false;
	});
});


var createField = 
{
	dataPrepare: function( form )
	{
		if( isSeaBattleMake == false )
		{
			console.info( 'Сперва расставьте корабли' );
			return false;
		}
		var fieldData = seaField.serializeField();
		return form.serialize()+'&field='+fieldData;
	},

	success: function( data )
	{
		var fieldData = seaField.serializeField();
		var formRedirect = $('#save_field_redirect');
		formRedirect.find( '[name="field"]' ).attr( 'value', fieldData );
		formRedirect.submit();
	},
	
/*	error: function( data )
	{

	}*/
};

var seaField =
{
	fieldSize: 20,			// Размер поля
	cellSize: 400/20,		// Размер ячейки в точках
	shipsAmount: 6,			// Количество кораблей
	maxTry: 10,				// Максимальное количество попыток расстановки кораблей
	field: null,			// Само поле
	context: null,			// Контекст вывода

	init: function()
	{
		var canvas = document.getElementById("create_field_field");
		this.context = canvas.getContext("2d");
		this.context.clearRect( 0, 0, canvas.width, canvas.height );

		this.field = new Array( this.fieldSize * this.fieldSize );
		for( var i=0; i<this.fieldSize * this.fieldSize; i++ )
			this.field[i] = 0;
	},

	makeField: function()
	{
		this.init();

		for( var shipSize = this.shipsAmount;  shipSize >= 1;  shipSize-- )
		{
			for( var shipCount = this.shipsAmount-shipSize+1;  shipCount >= 1;  shipCount-- )
			{
				var canPlace;
				var x;
				var y;
				var orientation;

				var iter = 0;
				var iter2 = 0;

				for( iter=0; iter<this.maxTry; iter++ )
				{
					// Ищем свободную клетку
					canPlace = true;
					orientation = this.getRandom( 2 );

					for( iter2=0; iter2<100; iter2++ )
					{
						if( orientation == 0 )
						{
							// Horizontal
							x = this.getRandom( this.fieldSize - shipSize + 1 );
							y = this.getRandom( this.fieldSize );
						}
						else
						{
							// Vertical
							x = this.getRandom( this.fieldSize );
							y = this.getRandom( this.fieldSize - shipSize + 1 );
						}

						if( this.checkCell( x, y ) )
							break;
					}
					if( iter2 >= 100 )
						break;


					// Пытаемся поставить корабль
					if( orientation == 0 )
					{
						// Horizontal
						for( var offs=1; offs<shipSize; offs++ )
						{
							if( this.checkCell( x+offs, y ) == false )
							{
								canPlace = false;
								break;
							}
						}
					}
					else
					{
						// Vertical
						for( var offs=1; offs<shipSize; offs++ )
						{
							if( this.checkCell( x, y+offs ) == false )
							{
								canPlace = false;
								break;
							}
						}
					}
					if( canPlace )
						break;
				}

				if( iter >= this.maxTry || iter2 >= 100 )
				{
					throw 'Не удалось расставить корабли, iter='+iter+' iter2='+iter2;
				}
				else if( iter > 1 )
				{
					//console.log( 'Корабль='+shipSize+' Попыток='+iter );
				}

				// Ставим корабль
				if( orientation == 0 )
				{
					// Horizontal
					for( var offs=0; offs<shipSize; offs++ )
						this.field[ this.getCellIndex( x+offs, y ) ] |= 1;
				}
				else
				{
					// Vertical
					for( var offs=0; offs<shipSize; offs++ )
						this.field[ this.getCellIndex( x, y+offs ) ] |= 1;
				}
			}
		}

		for( var yy=0; yy<=this.fieldSize; yy++ )
		{
			for( var xx=0; xx<=this.fieldSize; xx++ )
			{
				var isFill = (this.getCell( xx, yy ) == 0)? false : true;
				this.drawCell( xx, yy, isFill );
			}
		}
	},

	getRandom: function( max )
	{
		return Math.floor( Math.random() * max );
	},

	getCellIndex: function( x, y )
	{
		return y * this.fieldSize + x;
	},

	getCell: function( x, y )
	{
		return this.field[ y * this.fieldSize + x ];
	},

	checkCell: function( x, y )
	{
		// Проверяем клетку и вокруг
		for( var yy=y-1; yy<=y+1; yy++ )
		{
			for( var xx=x-1; xx<=x+1; xx++ )
			{
				if( xx>=0 && xx<this.fieldSize && yy>=0 && yy<this.fieldSize )
				{
					//console.log( "x="+xx+" y="+yy+" : "+this.getCell( xx, yy ) );
					if( this.getCell( xx, yy ) != 0 )
						return false;
				}
			}
		}
		return true;
	},

	drawCell: function( x, y, isFill )
	{
		this.context.fillStyle = ( isFill )
			? "rgba(100,100,100,1)"
			: "rgba(205,205,205,1)";

		this.context.fillRect( x * this.cellSize, y * this.cellSize, this.cellSize, this.cellSize );
	},

	serializeField: function()
	{
/*		var res = "";
		var total = 0;
		for( var key in this.field )
		{
			total++;
			res += "s:" + String(key).length
				+ ":\"" + String(key).replace(/"/g, "\"") + "\";s:" + String(this.field[key]).length + ":\"" + String(this.field[key]).replace(/"/g, "\"") + "\";";
		}
		res = "a:" + total + ":{" + res + "}";
		return res;*/

		return this.field.join('');
	}
};

/*(function($)
{
	$.fn.seafield = function()
	{
		return this.each( function()
		{

		});
	};
})(jQuery);
*/
