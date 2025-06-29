<?php

namespace Webkul\Core\Repositories;

use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Storage;

/**
 * Channel Reposotory
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class ChannelRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Core\Contracts\Channel';
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        if (isset($data['logo']) && is_array($data['logo']))
            unset($data['logo']);

        if (isset($data['favicon']) && is_array($data['favicon']))
            unset($data['favicon']);

        $channel = $this->model->create($data);

        $channel->locales()->sync($data['locales']);

        $channel->currencies()->sync($data['currencies']);

        $channel->inventory_sources()->sync($data['inventory_sources']);

        $this->uploadImages($data, $channel);

        $this->uploadImages($data, $channel, 'favicon');

        return $channel;
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $channel = $this->find($id);

        if (is_array($data['logo']))
            unset($data['logo']);

        if (is_array($data['favicon']))
            unset($data['favicon']);

        $channel->update($data);

        $channel->locales()->sync($data['locales']);

        $channel->currencies()->sync($data['currencies']);

        $channel->inventory_sources()->sync($data['inventory_sources']);

        $this->uploadImages($data, $channel);

        $this->uploadImages($data, $channel, 'favicon');

        return $channel;
    }

    /**
     * @param array $data
     * @param mixed $channel
     * @return void
     */
    public function uploadImages($data, $channel, $type = "logo")
    {

        if (isset($data[$type])) {
            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;
                $dir = 'channel/' . $channel->id;

                if (request()->hasFile($file)) {
                    if ($channel->{$type}) {
                        Storage::delete($channel->{$type});
                    }

                    $channel->{$type} = request()->file($file)->store($dir);
                    $channel->save();
                }
            }
        } else {
            if ($channel->{$type}) {
                Storage::delete($channel->{$type});
            }

            $channel->{$type} = null;
            $channel->save();
        }
    }
}