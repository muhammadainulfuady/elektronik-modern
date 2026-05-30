$word = New-Object -ComObject Word.Application
$word.Visible = $false
$doc = $word.Documents.Open("c:\laragon\www\elektronik-modern - Copy\SKPL Prototype_merapikan_5.docx")
$text = $doc.Content.Text
$text | Out-File -FilePath "c:\laragon\www\elektronik-modern - Copy\SKPL_text.txt" -Encoding UTF8
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done extracting SKPL"
