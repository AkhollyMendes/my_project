window.onload = function()
{
    sessionStart = Date.now();

    timer = setInterval(function()
    {   
		if (Date.now() - sessionStart > 15 * 60 * 1000)//15 minutos
		{
			clearTimeout(timer);
            window.location = "./logoff.php";
        }

    }, 1000);
};
