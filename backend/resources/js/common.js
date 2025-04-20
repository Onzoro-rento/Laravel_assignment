const nl2br = (str) => {
    var res = str.replace(/(\r\n|\n|\r)/g, "<br>");
    res = res.replace(/(\n|\r)/g, "<br>");
    return res;
}

export { nl2br };