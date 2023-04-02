<?php
    trait Json {
            public function asJson() : string {
                return json_encode(get_object_vars($this));
            }
        }