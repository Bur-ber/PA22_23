<?php
$faces = glob("../Resources/images/images/faces/*.png");
$bodies = glob("../Resources/images/images/bodies/*.png");
$eyes = glob("../Resources/images/images/eyes/*.png");
$mouths = glob("../Resources/images/images/mouths/*.png");
$noses = glob("../Resources/images/images/noses/*.png");
$hairs = glob("../Resources/images/images/hairs/*.png");
$i = 0;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Avatar Creator</title>
</head>

<body>
    <div class="container">
        <h1>Modifier son avatar</h1>
        <!-- Horizontal Buttons -->
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

            <!-- Hairs Button -->
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-hairs-tab" data-bs-toggle="pill" data-bs-target="#pills-hairs" type="button" role="tab" aria-controls="pills-hairs" aria-selected="true">Cheveux</button>
            </li>

            <!-- Faces Button -->
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-faces-tab" data-bs-toggle="pill" data-bs-target="#pills-faces" type="button" role="tab" aria-controls="pills-faces" aria-selected="false">Visages</button>
            </li>

            <!-- Eyes Button -->
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-eyes-tab" data-bs-toggle="pill" data-bs-target="#pills-eyes" type="button" role="tab" aria-controls="pills-eyes" aria-selected="false">Yeux</button>
            </li>

            <!-- Noses Button -->
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-noses-tab" data-bs-toggle="pill" data-bs-target="#pills-noses" type="button" role="tab" aria-controls="pills-noses" aria-selected="false">Nez</button>
            </li>

            <!-- Mouths Button -->
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-mouths-tab" data-bs-toggle="pill" data-bs-target="#pills-mouths" type="button" role="tab" aria-controls="pills-mouths" aria-selected="false">Bouches</button>
            </li>

            <!-- Bodies Button -->
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-bodies-tab" data-bs-toggle="pill" data-bs-target="#pills-bodies" type="button" role="tab" aria-controls="pills-bodies" aria-selected="false">Corps</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="pills-tabContent">

            <!-- Hairs Content -->
            <div class="tab-pane fade show active" id="pills-hairs" role="tabpanel" aria-labelledby="pills-hairs-tab">
                <!-- Cards for Hairs -->
                <div class="row hairs">
                    <?php foreach ($hairs as $item) : ?>
                        <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                            <div class="card <?php if ($i == 0) echo "selected";
                                                $i++; ?>" onclick="setSelected(this)" data-img_src="<?= $item ?>">
                                <img src="<?= $item ?>" class="card-img-top mx-auto" alt="Face 1">
                                <div class="card-body">
                                    <p class="card-text"><?= basename($item) ?></p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach;
                    $i = 0; ?>
                </div>
            </div>

            <!-- Faces Content -->
            <div class="tab-pane fade" id="pills-faces" role="tabpanel" aria-labelledby="pills-faces-tab">
                <!-- Cards for Faces -->
                <div class="row">
                    <?php foreach ($faces as $item) : ?>
                        <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                            <div class="card <?php if ($i == 0) echo "selected";
                                                $i++; ?>" onclick="setSelected(this)" data-img_src="<?= $item ?>">
                                <img src="<?= $item ?>" class="card-img-top mx-auto" alt="Face 1">
                                <div class="card-body">
                                    <p class="card-text"><?= basename($item) ?></p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach;
                    $i = 0; ?>
                </div>

            </div>

            <!-- Eyes Content -->
            <div class="tab-pane fade" id="pills-eyes" role="tabpanel" aria-labelledby="pills-eyes-tab">
                <!-- Cards for Eyes -->
                <div class="row">
                    <?php foreach ($eyes as $item) : ?>
                        <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                            <div class="card <?php if ($i == 0) echo "selected";
                                                $i++; ?>" onclick="setSelected(this)" data-img_src="<?= $item ?>">
                                <img src="<?= $item ?>" class="card-img-top mx-auto" alt="Face 1">
                                <div class="card-body">
                                    <p class="card-text"><?= basename($item) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                    $i = 0; ?>
                </div>

            </div>

            <!-- Noses Content -->
            <div class="tab-pane fade" id="pills-noses" role="tabpanel" aria-labelledby="pills-noses-tab">
                <!-- Cards for Noses -->
                <div class="row">
                    <?php foreach ($noses as $item) : ?>
                        <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                            <div class="card <?php if ($i == 0) echo "selected";
                                                $i++; ?>" onclick="setSelected(this)" data-img_src="<?= $item ?>">
                                <img src="<?= $item ?>" class="card-img-top mx-auto" alt="Face 1">
                                <div class="card-body">
                                    <p class="card-text"><?= basename($item) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                    $i = 0; ?>
                </div>
            </div>

            <!-- Mouths Content -->
            <div class="tab-pane fade" id="pills-mouths" role="tabpanel" aria-labelledby="pills-mouths-tab">
                <!-- Cards for Mouths -->
                <div class="row">
                    <?php foreach ($mouths as $item) : ?>
                        <div class="col-sm-6 col-md-4 col-lg-2 mb-3">
                            <div class="card <?php if ($i == 0) echo "selected";
                                                $i++; ?>" onclick="setSelected(this)" data-img_src="<?= $item ?>">
                                <img src="<?= $item ?>" class="card-img-top mx-auto" alt="Face 1">
                                <div class="card-body">
                                    <p class="card-text"><?= basename($item) ?></p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach;
                    $i = 0; ?>
                </div>
            </div>

            <!-- Bodies Content -->
            <div class="tab-pane fade" id="pills-bodies" role="tabpanel" aria-labelledby="pills-bodies-tab">
                <!-- Cards for Bodies -->
                <div class="row">
                    <?php foreach ($bodies as $item) : ?>
                        <div class="col-sm-6 col-md-4 col-lg-2 mb-3 col">
                            <div class="card <?php if ($i == 0) echo "selected";
                                                $i++; ?>" onclick="setSelected(this)" data-img_src="<?= $item ?>">
                                <img src="<?= $item ?>" class="card-img-top mx-auto" alt="Face 1">
                                <div class="card-body">
                                    <p class="card-text"><?= basename($item) ?></p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach;
                    $i = 0; ?>
                </div>
            </div>

        </div> <!-- End of Tab Content -->
        
        <div class="d-flex justify-content-center">
            <div>
                <h2>Aperçu:</h2>
                <div class="avatar-container" id="avatar-container">
                </div>
            </div>
            
        </div>
        <div class="d-flex justify-content-center">
        <div><button onclick="saveAvatar()" class="btn btn-primary">Sauvegarder votre avatar</button></div>
        </div>

        
    </div>


    <script src="js/avatarMaker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>