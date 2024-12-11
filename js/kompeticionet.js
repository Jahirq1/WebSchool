const kompeticioniDropdown = document.getElementById('kompeticioni');
const tekstiElement = document.querySelector('.left-section p');
const fotoElement = document.querySelector('.right img');

kompeticioniDropdown.addEventListener('change', () => {
    const kompeticioni = kompeticioniDropdown.value;

   
    if(kompeticioni=='CS:go2') {
        tekstiElement.innerHTML = `
        <strong>CS2</strong> është një lojë e njohur dhe shumë popullore në komunitetin e E-Sports.
        Turneu do të bashkojë lojtarët më të mirë të UBT-së për të luftuar për titullin e kampionit.
        Ky turne është një mundësi për të provuar aftësitë taktike dhe individuale në një nga lojërat më të njohura të FPS (First-Person Shooter).
       <li> <strong>Formati:</strong>
        Ekipe me nga 5 lojtarë do të garojnë kundër njëri-tjetrit në fazën grupore, duke kaluar më pas në eliminim direkt për të arritur finalen. Lojtarët do të testojnë aftësitë e tyre strategjike dhe kohezionin e ekipit.
        <li><strong>Vendndodhja:</strong> Qendra Teknologjike e UBT-së, e pajisur me kompjuterë dhe ekrane të avancuara për lojëra profesionale.
        <li><strong>Çmimet:</strong>
        <ul>
            <li>Vendi i parë: 500€</li>
            <li>Vendi i dytë: 300€</li>
            <li>Vendi i tretë: 100€</li>
        </ul>
        <li><strong>Përfitimet:</strong> Pjesëmarrësit do të kenë mundësinë të bëhen pjesë e një komuniteti E-Sports dhe të zhvillojnë aftësitë e tyre në një mjedis konkurrues dhe profesional.
    `;
            fotoElement.src = '../img/programit/csgo2.jpeg'; 
           

     } else if (kompeticioni=='Karate'){
        tekstiElement.innerHTML = `
        <strong>Karate</strong> është një art marcial që zhvillon forcën fizike, disiplinën dhe teknikat e luftimit.
        Ky turne ofron mundësinë për të garuar në dy kategori: Kata (performancë teknike) dhe Kumite (luftë sportive).
        <li><strong>Formati:</strong>
        Pjesëmarrësit do të garojnë në grupe të ndryshme sipas niveleve të aftësive: fillestar, mesatar dhe të avancuar. Pjesëmarrësit do të garojnë për të fituar tituj dhe medalje në të dyja formatet.
       <li> <strong>Vendndodhja:</strong> Palestra e Arteve Marciale në UBT, e pajisur me kushte optimale për zhvillimin e luftërave.
        <li><strong>Çmimet:</strong>
        <ul>
            <li>Medalje për tre vendet e para në secilën kategori (Kata dhe Kumite).</li>
        </ul>
        <li><strong>Përfitimet:</strong> Pjesëmarrësit do të zhvillojnë aftësitë e tyre teknike, përmirësojnë forcën dhe qëndrueshmërinë, si dhe përjetojnë një eksperiencë të thelluar në karate.
    `;
            fotoElement.src = '../img/programit/karate.jpg';
         

     }else if(kompeticioni=='Football'){
        tekstiElement.innerHTML = `
        <strong>Futboll </strong> është një version i shkurtuar i futbollit tradicional, por shumë i intensifikuar dhe i shpejtë. Ky turne është ideali për të gjithë ata që duan të shfaqin aftësitë e tyre me topin dhe të garojnë për një vend në finales.
      <li>  <strong>Formati:</strong>
        Ekipet do të përbëhen nga 7 lojtarë (5 në fushë + 2 rezervë). Pas një faze grupore, ekipi fitues do të kalojë në fazën e eliminimit deri në finale.
        <li><strong>Vendndodhja:</strong> Fusha sportive e UBT-së, e pajisur me kushte ideale për zhvillimin e turneve mini-futboll.
        <li><strong>Çmimet:</strong>
        <ul>
            <li>Vendi i parë: Kupë dhe pajisje sportive për ekipin.</li>
            <li>Vendi i dytë: Medalje për çdo anëtar të ekipit.</li>
        </ul>
       <li> <strong>Përfitimet:</strong> Ky është një mundësi për të zhvilluar frymën e ekipit, aftësitë fizike dhe për të shijuar futbollin në një ambient miqësor dhe konkurrues.
    `;
       
            fotoElement.src = '../img/programit/futboll.jpg';
          

     }else if(kompeticioni=='Handball'){
        tekstiElement.innerHTML = `
        <strong>Hendboll</strong> është një sport dinamik që kërkon shpejtësi, forcë dhe koordinim të lartë të ekipit. Ky turne është ideal për ata që duan të provojnë aftësitë e tyre në këtë sport të shpejtë dhe fizik.
        <li><strong>Formati:</strong>
        Ekipet do të përbëhen nga 7 lojtarë. Pas fazës grupore, ekipet do të kalojnë në fazën e eliminimit dhe më pas në finale.
        <li><strong>Vendndodhja:</strong> Palestra e UBT-së, e pajisur për garat e hendbollit.
        <li><strong>Çmimet:</strong>
      <ul>
            <li>Vendi i parë: Kupë dhe medalje për çdo anëtar të ekipit.</li>
            <li>Vendi i dytë: Medalje për ekipin.</li>
        </ul>
        <strong>Përfitimet:</strong> Pjesëmarrësit do të zhvillojnë shkathtësitë e tyre atletike, si dhe do të krijojnë një frymë ekipore dhe shoqërore.
    `;
            fotoElement.src = '../img/programit/Handball.jpg';
       

      }else{ 
        tekstiElement.innerHTML = `
        <strong>UBT Sports & E-Sports Tournament 2024</strong>
        <strong>Data:</strong> 15-17 Dhjetor 2024<br>
        <strong>Vendi:</strong> Kampusi i UBT-së
        <p>UBT organizon një turne të veçantë sportiv dhe E-Sports, duke ofruar mundësi për argëtim dhe konkurrencë për studentët dhe stafin.
        Ky aktivitet përfshin disa disiplina sportive dhe një kompeticion të veçantë në botën e lojërave elektronike.</p>
    `;
                fotoElement.src = '../img/post/post4.png'; 

        }
    });
 
    document.addEventListener("DOMContentLoaded", () => {
        const toggleButton = document.querySelector('.toggle-button');
        const navbarLinks = document.querySelector('.navbar-links');
      
        toggleButton.addEventListener('click', () => {
            navbarLinks.classList.toggle('active');
        });
      });